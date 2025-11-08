<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SerialController as AdminSerialController;
use App\Http\Controllers\Admin\ServicePackageController;
use App\Http\Controllers\Admin\VoucherController as AdminVoucherController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Storage;

// Fallback serving for storage files when symlink is not available (shared hosting)
// On proper servers, prefer using `php artisan storage:link` and let web server serve files directly.
Route::get('/storage/{path}', function (string $path) {
    $relativePath = ltrim($path, '/');
    if (!Storage::disk('public')->exists($relativePath)) {
        abort(404);
    }

    $mime = Storage::disk('public')->mimeType($relativePath) ?: 'application/octet-stream';
    $contents = Storage::disk('public')->get($relativePath);

    return response($contents, 200)
        ->header('Content-Type', $mime)
        ->header('Cache-Control', 'public, max-age='.(60*60*24*7));
})->where('path', '.*');

// Debug route
Route::get('/debug-products', function() {
    $products = App\Models\Product::all();
    echo "Total products: " . $products->count() . "<br>";
    foreach($products as $product) {
        echo "ID: {$product->id}, Name: {$product->name}, Slug: " . ($product->slug ?? 'null') . ", Active: " . ($product->is_active ? 'Yes' : 'No') . "<br>";
        echo "Category ID: " . ($product->category_id ?? 'null') . "<br>";
        echo "Image: " . ($product->image ?? 'null') . "<br>";
        echo "Price 6m: " . ($product->price_6_months ?? 'null') . "<br>";
        echo "<hr>";
    }
});

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Public service package detail (so homepage cards can link to a public details page)
Route::get('/service-packages/{servicePackage}', [HomeController::class, 'servicePackageShow'])->name('service-packages.show');

// Product routes
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [ProductController::class, 'showByCategory'])->name('products.by-category');

// Rental routes (view only)
Route::middleware(['auth'])->group(function () {
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    // use {order} so implicit model binding resolves to Order model in controller
    Route::get('/rentals/{order}', [RentalController::class, 'show'])->name('rentals.show');
});

// Check-in routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkin', [CheckInController::class, 'index'])->name('checkin.index');
    Route::post('/checkin', [CheckInController::class, 'checkIn'])->name('checkin.checkin');
    Route::post('/checkin/{checkIn}/claim', [CheckInController::class, 'claimReward'])->name('checkin.claim');
});

require __DIR__.'/auth.php';

// Admin: banners (controller self-checks is_admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Banner management
    Route::get('/admin/banners', [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/admin/banners/create', [BannerController::class, 'create'])->name('admin.banners.create');
    Route::post('/admin/banners', [BannerController::class, 'store'])->name('admin.banners.store');
    Route::get('/admin/banners/{banner}/edit', [BannerController::class, 'edit'])->name('admin.banners.edit');
    Route::put('/admin/banners/{banner}', [BannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('/admin/banners/{banner}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');

    // Product management
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::post('/admin/products/{product}/delete', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    // Category management
    Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::post('/admin/categories/{category}/delete', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Order management
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/rentals', [AdminOrderController::class, 'rentals'])->name('admin.rentals.index');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::post('/admin/orders/{order}/delete', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

    // Service Package management
    // AJAX: check if a service package name already exists (used by client-side validation)
    Route::get('/admin/service-packages/check-name', [ServicePackageController::class, 'checkName'])
        ->name('admin.service-packages.check-name');

    Route::resource('admin/service-packages', ServicePackageController::class)->names([
        'index' => 'admin.service-packages.index',
        'create' => 'admin.service-packages.create',
        'store' => 'admin.service-packages.store',
        'show' => 'admin.service-packages.show',
        'edit' => 'admin.service-packages.edit',
        'update' => 'admin.service-packages.update',
        'destroy' => 'admin.service-packages.destroy'
    ]);

    // Serial management (product serial numbers)
    Route::get('/admin/serials', [AdminSerialController::class, 'index'])->name('admin.serials.index');
    Route::get('/admin/serials/search', [AdminSerialController::class, 'search'])->name('admin.serials.search');
    Route::get('/admin/serials/{product}', [AdminSerialController::class, 'show'])->name('admin.serials.show');
    Route::post('/admin/serials/{product}', [AdminSerialController::class, 'update'])->name('admin.serials.update');

    // Permission management
    Route::get('/admin/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('admin.permissions.index')->middleware('admin');

    // Voucher management
    Route::get('/admin/vouchers', [AdminVoucherController::class, 'index'])->name('admin.vouchers.index');
    Route::get('/admin/vouchers/create', [AdminVoucherController::class, 'create'])->name('admin.vouchers.create');
    Route::post('/admin/vouchers', [AdminVoucherController::class, 'store'])->name('admin.vouchers.store');
    Route::get('/admin/vouchers/{voucher}/edit', [AdminVoucherController::class, 'edit'])->name('admin.vouchers.edit');
    Route::put('/admin/vouchers/{voucher}', [AdminVoucherController::class, 'update'])->name('admin.vouchers.update');
    Route::delete('/admin/vouchers/{voucher}', [AdminVoucherController::class, 'destroy'])->name('admin.vouchers.destroy');
    Route::post('/admin/vouchers/{voucher}/toggle', [AdminVoucherController::class, 'toggleStatus'])->name('admin.vouchers.toggle');
    Route::post('/admin/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'update'])->name('admin.permissions.update')->middleware('admin');
    Route::post('/admin/users/{user}/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'updateUserPermissions'])->name('admin.users.permissions.update')->middleware('admin');
    Route::get('/admin/permissions/{user}/permissions', [App\Http\Controllers\Admin\PermissionController::class, 'getUserPermissions'])->name('admin.permissions.get')->middleware('admin');

    // User management
    Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index')->middleware('admin');
    Route::get('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show')->middleware('admin');
    Route::patch('/admin/users/{user}/toggle-admin', [App\Http\Controllers\Admin\UserController::class, 'toggleAdmin'])->name('admin.users.toggle-admin')->middleware('admin');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy')->middleware('admin');

    // Rating management
    Route::get('/admin/ratings', [AdminRatingController::class, 'index'])->name('admin.ratings.index')->middleware('admin');
    Route::patch('/admin/ratings/{rating}/status', [AdminRatingController::class, 'updateStatus'])->name('admin.ratings.update-status')->middleware('admin');
    Route::delete('/admin/ratings/{rating}', [AdminRatingController::class, 'destroy'])->name('admin.ratings.destroy')->middleware('admin');

    // Test permission route
    Route::get('/admin/test-permission', function() {
        if (\App\Helpers\PermissionHelper::hasPermission('orders_view')) {
            return 'Bạn có quyền xem đơn hàng!';
        }
        return 'Bạn không có quyền xem đơn hàng!';
    })->middleware(['auth', 'admin'])->name('admin.test.permission');

    // Comment admin management
    Route::get('/admin/comments', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('admin.comments.index');
    Route::delete('/admin/comments/{comment}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('admin.comments.destroy');
});

// Cart routes (must be logged in)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}/remove', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // User order history (non-admin)
    Route::get('/my-orders', [CheckoutController::class, 'myOrders'])->name('orders.index');
    Route::get('/my-orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');

    // Account profile
    Route::get('/account', [\App\Http\Controllers\AccountController::class, 'show'])->name('account.show');

    // Ratings
    Route::post('/products/{product}/rate', [ProductController::class, 'rate'])->name('products.rate');
    // Comments
    Route::post('/products/{product}/comment', [ProductController::class, 'storeComment'])->name('products.comment');
});
