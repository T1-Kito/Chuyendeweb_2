<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Rental;
use App\Models\ServicePackage;
use App\Models\Favorite;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\ContactMail;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $banners = collect();
        if (Schema::hasTable('banners')) {
            $banners = Banner::where('is_active', true)->orderBy('sort_order')->get();
            \Log::info('Banners loaded: ' . $banners->count());
            \Log::info('Banners data: ' . $banners->toJson());
        } else {
            \Log::info('Banners table does not exist');
        }

        // Build products query
        $query = Product::where('is_active', true);

        // Filter by category if provided
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        $products = $query->orderBy('created_at', 'desc')
            ->take(12) // Increase limit to show more products
            ->get();

        // Lấy sản phẩm được thuê nhiều nhất (most rented products)
        $featuredProducts = Product::where('is_active', true)
            ->withCount(['rentalItems as rental_count' => function($query) {
                $query->where('created_at', '>=', now()->subMonths(6)); // Lấy số lần thuê trong 6 tháng gần đây
            }])
            ->orderBy('rental_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Nếu không có sản phẩm nào được thuê, lấy sản phẩm nổi bật
        if ($featuredProducts->where('rental_count', '>', 0)->isEmpty()) {
            $featuredProducts = Product::where('is_active', true)
                ->where('is_featured', true)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Nếu vẫn không có, lấy 5 sản phẩm mới nhất
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        $categories = Category::where('is_active', true)->get();

        // Recent rentals feed (show latest unique rentals)
        $recentRentals = collect();
        if (Schema::hasTable('rentals')) {
            $recentRentals = Rental::with(['user', 'rentalItems.product'])
                ->orderBy('created_at', 'desc')
                ->limit(200)
                ->get();
        }

        $selectedCategory = $request->get('category', 'all');

        // Check favorites cho người dùng đã đăng nhập (nếu có bảng favorites)
        if (Schema::hasTable('favorites') && Auth::check()) {
            $favoriteProductIds = Favorite::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();

            $products->transform(function ($product) use ($favoriteProductIds) {
                $product->isFavorited = in_array($product->id, $favoriteProductIds);
                return $product;
            });

            $featuredProducts->transform(function ($product) use ($favoriteProductIds) {
                $product->isFavorited = in_array($product->id, $favoriteProductIds);
                return $product;
            });
        } else {
            // Nếu chưa đăng nhập hoặc chưa có bảng favorites thì mặc định không đánh dấu yêu thích
            $products->transform(function ($product) {
                $product->isFavorited = false;
                return $product;
            });

            $featuredProducts->transform(function ($product) {
                $product->isFavorited = false;
                return $product;
            });
        }

        // Get service packages
        $servicePackages = ServicePackage::active()->ordered()->get();

        return view('home', compact('products', 'categories', 'banners', 'selectedCategory', 'featuredProducts', 'recentRentals', 'servicePackages'));
    }

    public function about()
    {
        $servicePackages = ServicePackage::active()->ordered()->get();
        return view('about', compact('servicePackages'));
    }

    public function contact()
    {
        $bannerUrl = null;

        $fileCandidates = [
            'bannerlienhe.jpg',
            'banerlienhe.jpg',
            'banners/bannerlienhe.jpg',
            'banners/banerlienhe.jpg',
        ];

        foreach ($fileCandidates as $candidate) {
            if (Storage::disk('public')->exists($candidate)) {
                $bannerUrl = Storage::url($candidate);
                break;
            }

            if (file_exists(public_path($candidate))) {
                $bannerUrl = asset($candidate);
                break;
            }
        }

        if (!$bannerUrl && Schema::hasTable('banners')) {
            $banner = Banner::where('is_active', true)
                ->where(function ($query) {
                    $query->where('title', 'contact-banner')
                          ->orWhere('title', 'contact')
                          ->orWhere('link_url', 'contact-banner');
                })
                ->orderBy('sort_order')
                ->first();

            if ($banner && !empty($banner->image_path)) {
                if (str_starts_with($banner->image_path, ['http://', 'https://'])) {
                    $bannerUrl = $banner->image_path;
                } elseif (Storage::disk('public')->exists($banner->image_path)) {
                    $bannerUrl = Storage::url($banner->image_path);
                } elseif (file_exists(public_path($banner->image_path))) {
                    $bannerUrl = asset($banner->image_path);
                }
            }
        }

        return view('contact', [
            'contactBannerUrl' => $bannerUrl,
        ]);
    }

    public function submitContact(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'phone' => ['nullable', 'string', 'max:20'],
                'subject' => ['required', 'string', 'in:general,rental,support,partnership,other'],
                'message' => ['required', 'string', 'max:5000'],
                'newsletter' => ['nullable', 'boolean'],
            ]);

            // Gửi email về địa chỉ trong MAIL_FROM_ADDRESS
            $toEmail = config('mail.from.address');

            if (empty($toEmail)) {
                \Log::error('Contact form error: MAIL_FROM_ADDRESS is not configured');
                throw new \Exception('Cấu hình email chưa được thiết lập. Vui lòng liên hệ quản trị viên.');
            }

            Mail::to($toEmail)->send(new ContactMail(
                $validated['name'],
                $validated['email'],
                $validated['phone'] ?? null,
                $validated['subject'],
                $validated['message'],
                $request->has('newsletter') && $request->newsletter == '1'
            ));

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.'
                ]);
            }

            return back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng kiểm tra lại thông tin đã nhập.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            \Log::error('Contact form error trace: ' . $e->getTraceAsString());

            $errorMessage = 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.';

            // Nếu là lỗi cấu hình email, hiển thị thông báo cụ thể hơn
            if (str_contains($e->getMessage(), 'MAIL_FROM_ADDRESS') || str_contains($e->getMessage(), 'cấu hình')) {
                $errorMessage = $e->getMessage();
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Hiển thị chi tiết một gói dịch vụ cho phía user
     */
    public function showServicePackage(ServicePackage $servicePackage)
    {
        // Chỉ cho phép xem các gói đang hoạt động
        if (!$servicePackage->is_active) {
            abort(404);
        }

        return view('service-packages.show', compact('servicePackage'));
    }

}
