<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Notifications\NewCommentNotification;
use App\Notifications\NewRatingNotification;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true);

        // Filter by category (slug)
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Search by name / description / model
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Filter by price range (dựa trên price_1_month / price_6_months)
        if ($request->filled('min_price')) {
            $minPrice = (int) $request->input('min_price');
            $query->where(function ($q) use ($minPrice) {
                $q->where('price_1_month', '>=', $minPrice)
                  ->orWhere('price_6_months', '>=', $minPrice);
            });
        }

        if ($request->filled('max_price')) {
            $maxPrice = (int) $request->input('max_price');
            $query->where(function ($q) use ($maxPrice) {
                $q->where('price_1_month', '<=', $maxPrice)
                  ->orWhere('price_6_months', '<=', $maxPrice);
            });
        }

        // Sorting giống showByCategory
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

        $products = $query->paginate(12)->withQueryString();

        // Gắn cờ yêu thích cho user đang đăng nhập
        if (Auth::check()) {
            $favoriteProductIds = Favorite::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();

            $products->getCollection()->transform(function ($product) use ($favoriteProductIds) {
                $product->isFavorited = in_array($product->id, $favoriteProductIds);
                return $product;
            });
        } else {
            $products->getCollection()->transform(function ($product) {
                $product->isFavorited = false;
                return $product;
            });
        }

        $categories = Category::where('is_active', true)->get();
        
        return view('products.index', compact('products', 'categories', 'sort'));
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
        
        // Lấy danh sách bình luận mới nhất (chỉ comments gốc, không có parent_id)
        $comments = $product->comments()
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->orderByDesc('created_at')
            ->get();

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
        $isFavorited = false;
        if (Auth::check()) {
            $userRating = Rating::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->first();
            $isFavorited = Favorite::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
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
            'packageOptions',
            'isFavorited'
        ));
    }

    public function storeComment(Request $request, Product $product)
    {
        $this->middleware('auth');
        
        // Trim và kiểm tra khoảng trắng
        $content = trim($request->input('content', ''));
        
        // Kiểm tra khoảng trắng 2 bytes (full-width space)
        $content = str_replace(['　', "\xC2\xA0"], ' ', $content); // Replace full-width space và non-breaking space
        $content = trim($content);
        
        $validated = $request->validate([
            'content' => ['required','string','max:1000', function ($attribute, $value, $fail) {
                $trimmed = trim($value);
                // Kiểm tra sau khi trim có còn nội dung không
                if (empty($trimmed)) {
                    $fail('Nội dung bình luận không được để trống hoặc chỉ chứa khoảng trắng.');
                }
                // Kiểm tra độ dài sau khi trim
                if (mb_strlen($trimmed) > 1000) {
                    $fail('Nội dung bình luận không được vượt quá 1000 ký tự.');
                }
            }],
        ], [
            'content.required' => 'Vui lòng nhập nội dung bình luận.',
            'content.max' => 'Nội dung bình luận không được vượt quá 1000 ký tự.',
        ]);
        
        // Trim lại sau khi validate
        $content = trim($validated['content']);
        
        $comment = Comment::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'content' => $content,
        ]);
        
        // Load quan hệ để notification có đủ thông tin
        $comment->load(['user', 'product']);
        
        // Gửi notification tới tất cả admin
        try {
            $admins = User::where('is_admin', true)->get();
            \Log::info('Sending comment notification to admins', [
                'comment_id' => $comment->id,
                'admin_count' => $admins->count(),
                'admin_ids' => $admins->pluck('id')->toArray()
            ]);
            
            foreach ($admins as $admin) {
                $admin->notify(new NewCommentNotification($comment));
                \Log::info('Comment notification sent to admin', ['admin_id' => $admin->id, 'admin_name' => $admin->name]);
            }
        } catch (\Exception $e) {
            \Log::error('Error sending comment notification', ['error' => $e->getMessage()]);
        }
        
        return back()->with('success', 'Cảm ơn bạn đã bình luận!');
    }

    public function replyComment(Request $request, Product $product, $commentId)
    {
        $this->middleware('auth');
        
        try {
            // Tìm comment gốc
            $parentComment = Comment::where('id', $commentId)
                ->where('product_id', $product->id)
                ->first();
            
            if (!$parentComment) {
                return back()->with('error', 'Bình luận không tồn tại.');
            }

            // Validate
            $content = trim($request->input('content', ''));
            $content = str_replace(['　', "\xC2\xA0"], ' ', $content);
            $content = trim($content);

            $validated = $request->validate([
                'content' => ['required','string','max:1000', function ($attribute, $value, $fail) {
                    $trimmed = trim($value);
                    if (empty($trimmed)) {
                        $fail('Nội dung trả lời không được để trống hoặc chỉ chứa khoảng trắng.');
                    }
                    if (mb_strlen($trimmed) > 1000) {
                        $fail('Nội dung trả lời không được vượt quá 1000 ký tự.');
                    }
                }],
            ], [
                'content.required' => 'Vui lòng nhập nội dung trả lời.',
                'content.max' => 'Nội dung trả lời không được vượt quá 1000 ký tự.',
            ]);

            // Tạo reply
            $reply = Comment::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'parent_id' => $parentComment->id,
                'content' => $content,
            ]);

            // Load quan hệ
            $reply->load(['user', 'product']);

            // Gửi notification cho admin nếu user trả lời comment của admin
            if ($parentComment->user && $parentComment->user->is_admin) {
                try {
                    $admins = User::where('is_admin', true)->get();
                    foreach ($admins as $admin) {
                        $admin->notify(new NewCommentNotification($reply));
                    }
                } catch (\Exception $e) {
                    \Log::error('Error sending reply notification to admin', ['error' => $e->getMessage()]);
                }
            } elseif ($parentComment->user_id != auth()->id()) {
                // Gửi notification cho user đã bình luận (nếu không phải chính họ)
                try {
                    $parentComment->user->notify(new NewCommentNotification($reply));
                } catch (\Exception $e) {
                    \Log::error('Error sending reply notification', ['error' => $e->getMessage()]);
                }
            }

            return back()->with('success', 'Đã trả lời bình luận thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error replying to comment', [
                'error' => $e->getMessage(),
                'comment_id' => $commentId ?? null,
                'product_id' => $product->id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi trả lời bình luận. Vui lòng thử lại.')->withInput();
        }
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
        
        // Check favorites for authenticated users
        if (Auth::check()) {
            $favoriteProductIds = Favorite::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
            
            $products->getCollection()->transform(function ($product) use ($favoriteProductIds) {
                $product->isFavorited = in_array($product->id, $favoriteProductIds);
                return $product;
            });
        } else {
            $products->getCollection()->transform(function ($product) {
                $product->isFavorited = false;
                return $product;
            });
        }
        
        $otherCategories = Category::where('is_active', true)
            ->where('id', '!=', $category->id)
            ->withCount('products')
            ->take(6)
            ->get();
        
        return view('products.by-category', compact('category', 'products', 'otherCategories', 'sort'));
    }

    public function rate(Request $request, Product $product)
    {
        try {
            $packageValues = $this->availablePackageMonths($product);

            $rules = [
                'stars' => ['required', 'integer', 'between:1,5'],
                'content' => ['required', 'string', 'max:500', function ($attribute, $value, $fail) {
                    $trimmed = trim($value);
                    // Kiểm tra sau khi trim có còn nội dung không
                    if (empty($trimmed)) {
                        $fail('Nội dung đánh giá không được để trống hoặc chỉ chứa khoảng trắng.');
                    }
                    // Kiểm tra độ dài sau khi trim
                    if (mb_strlen($trimmed) > 500) {
                        $fail('Nội dung đánh giá không được vượt quá 500 ký tự.');
                    }
                }],
                'is_anonymous' => ['nullable', 'boolean'],
            ];

            if (count($packageValues) > 0) {
                $rules['package_months'] = ['nullable', 'integer', Rule::in($packageValues)];
            } else {
                $rules['package_months'] = ['nullable', 'integer'];
            }

            $validated = $request->validate($rules, [
                'content.required' => 'Vui lòng nhập nội dung đánh giá.',
                'content.max' => 'Nội dung tối đa 500 ký tự.',
                'stars.required' => 'Vui lòng chọn số sao.',
                'stars.between' => 'Số sao hợp lệ từ 1 đến 5.',
                'package_months.in' => 'Gói thuê không hợp lệ.',
            ]);

            // Trim và xử lý khoảng trắng
            $content = trim($validated['content']);
            // Kiểm tra khoảng trắng 2 bytes (full-width space)
            $content = str_replace(['　', "\xC2\xA0"], ' ', $content); // Replace full-width space và non-breaking space
            $content = trim($content);

            $payload = [
                'stars' => (int) $validated['stars'],
                'content' => $content,
                'is_anonymous' => (bool) ($validated['is_anonymous'] ?? false),
                'package_months' => isset($validated['package_months']) && $validated['package_months'] !== '' 
                    ? (int) $validated['package_months'] 
                    : null,
                'status' => Rating::STATUS_PENDING,
                'reviewed_at' => null,
            ];

            $rating = Rating::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                ],
                $payload
            );

            // Load quan hệ để notification có đủ thông tin
            $rating->load(['user', 'product']);

            // Gửi notification tới tất cả admin khi có đánh giá mới
            try {
                $admins = User::where('is_admin', true)->get();
                \Log::info('Sending rating notification to admins', [
                    'rating_id' => $rating->id,
                    'admin_count' => $admins->count(),
                    'admin_ids' => $admins->pluck('id')->toArray()
                ]);
                
                foreach ($admins as $admin) {
                    $admin->notify(new NewRatingNotification($rating));
                    \Log::info('Notification sent to admin', ['admin_id' => $admin->id, 'admin_name' => $admin->name]);
                }
            } catch (\Exception $e) {
                \Log::error('Error sending rating notification', ['error' => $e->getMessage()]);
            }

            return back()->with('success', 'Đánh giá của bạn đã được ghi nhận và sẽ hiển thị sau khi quản trị viên duyệt.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exception để Laravel xử lý
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error in rate method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'product_id' => $product->id ?? null,
                'user_id' => Auth::id()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại sau.')->withInput();
        }
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
