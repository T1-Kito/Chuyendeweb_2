<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Rental;
use App\Models\ServicePackage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

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

}
