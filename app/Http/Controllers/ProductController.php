<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('daily_price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('daily_price', '<=', $request->max_price);
        }
        
        // Filter by rental period
        if ($request->has('period') && $request->period != '') {
            $period = $request->period;
            if ($period == 'daily') {
                $query->orderBy('daily_price', 'asc');
            } elseif ($period == 'weekly') {
                $query->orderBy('weekly_price', 'asc');
            } elseif ($period == 'monthly') {
                $query->orderBy('monthly_price', 'asc');
            }
        }
        
        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();
        
        return view('products.index', compact('products', 'categories'));
    }

    public function show($slugOrId)
    {
        $query = Product::with('category')->where('is_active', true);

        if (is_numeric($slugOrId)) {
            $query->where('id', $slugOrId);
        } else {
            $query->where('slug', $slugOrId);
        }

        $product = $query->firstOrFail();
        
        $otherProducts = Product::where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        return view('products.show', compact('product', 'otherProducts'));
    }

    /**
     * Show products by category
     */
    public function showByCategory(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        $query = Product::with('category')
            ->where('category_id', $category->id)
            ->where('is_active', true);
        
        // Handle sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price_1_month', 'asc')
                      ->orderBy('price_6_months', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_1_month', 'desc')
                      ->orderBy('price_6_months', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->paginate(12)->appends(['sort' => $sort]);
        
        $otherCategories = Category::where('is_active', true)
            ->where('id', '!=', $category->id)
            ->withCount('products')
            ->take(6)
            ->get();
        
        return view('products.by-category', compact('category', 'products', 'otherCategories', 'sort'));
    }
}
