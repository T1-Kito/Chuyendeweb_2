<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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

    public function show(Request $request, $slugOrId)
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
        
        // Lấy danh sách bình luận mới nhất
        $comments = $product->comments()->with('user')->orderByDesc('created_at')->get();

        $ratings = $product->approvedRatings()
            ->with('user')
            ->orderByDesc('created_at')
            ->paginate(5, ['*'], 'ratings_page')
            ->withQueryString();

        $distribution = $product->approvedRatings()
            ->select('stars', DB::raw('COUNT(*) as total'))
            ->groupBy('stars')
            ->pluck('total', 'stars');

        $totalRatings = (int) $distribution->sum();
        $ratingStats = collect(range(5, 1))->mapWithKeys(function ($stars) use ($distribution, $totalRatings) {
            $count = (int) ($distribution[$stars] ?? 0);
            $percentage = $totalRatings > 0 ? round(($count / $totalRatings) * 100) : 0;
            return [$stars => ['count' => $count, 'percentage' => $percentage]];
        });

        $userRating = null;
        if (Auth::check()) {
            $userRating = Rating::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->first();
        }

        $packageOptions = $this->availablePackageMonths($product);
        
        return view('products.show', compact(
            'product',
            'otherProducts',
            'comments',
            'ratings',
            'ratingStats',
            'totalRatings',
            'userRating',
            'packageOptions'
        ));
    }

    public function storeComment(Request $request, Product $product)
    {
        $this->middleware('auth');
        $validated = $request->validate([
            'content' => ['required','string','max:1000'],
        ]);
        Comment::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);
        return back()->with('success', 'Cảm ơn bạn đã bình luận!');
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

    public function rate(Request $request, Product $product)
    {
        $packageValues = $this->availablePackageMonths($product);

        $rules = [
            'stars' => ['required', 'integer', 'between:1,5'],
            'content' => ['required', 'string', 'max:500'],
            'is_anonymous' => ['nullable', 'boolean'],
        ];

        if (count($packageValues)) {
            $rules['package_months'] = ['nullable', 'integer', Rule::in($packageValues)];
        } else {
            $rules['package_months'] = ['nullable', 'integer'];
        }

        $validated = $request->validate($rules, [
            'content.required' => 'Vui lòng nhập nội dung đánh giá.',
            'content.max' => 'Nội dung tối đa 500 ký tự.',
            'stars.required' => 'Vui lòng chọn số sao.',
            'stars.between' => 'Số sao hợp lệ từ 1 đến 5.',
        ]);

        $payload = [
            'stars' => (int) $validated['stars'],
            'content' => trim($validated['content']),
            'is_anonymous' => (bool) ($validated['is_anonymous'] ?? false),
            'package_months' => $validated['package_months'] ?? null,
            'status' => Rating::STATUS_PENDING,
            'reviewed_at' => null,
        ];

        Rating::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id' => Auth::id(),
            ],
            $payload
        );

        return back()->with('success', 'Đánh giá của bạn đã được ghi nhận và sẽ hiển thị sau khi quản trị viên duyệt.');
    }

    protected function availablePackageMonths(Product $product): array
    {
        $packages = [
            1 => $product->price_1_month,
            6 => $product->price_6_months,
            12 => $product->price_12_months,
            18 => $product->price_18_months,
            24 => $product->price_24_months,
        ];

        return array_keys(array_filter($packages, static function ($price) {
            return !is_null($price);
        }));
    }
}
