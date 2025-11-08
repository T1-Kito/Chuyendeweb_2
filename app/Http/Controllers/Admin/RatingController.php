<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Notifications\RatingApprovedNotification;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $productId = $request->get('product_id');
        $keyword = $request->get('keyword');

        $ratingsQuery = Rating::with(['product', 'user'])
            ->orderByDesc('created_at');

        if ($status) {
            $ratingsQuery->where('status', $status);
        }

        if ($productId) {
            $ratingsQuery->where('product_id', $productId);
        }

        if ($keyword) {
            $ratingsQuery->where(function ($query) use ($keyword) {
                $query->whereHas('user', function ($userQuery) use ($keyword) {
                    $userQuery->where('name', 'like', "%{$keyword}%")
                        ->orWhere('email', 'like', "%{$keyword}%");
                })->orWhereHas('product', function ($productQuery) use ($keyword) {
                    $productQuery->where('name', 'like', "%{$keyword}%");
                });
            });
        }

        $ratings = $ratingsQuery->paginate(12)->withQueryString();

        $approvedQuery = Rating::approved();
        $totalApproved = (int) $approvedQuery->count();
        $averageRating = $totalApproved > 0 ? round((float) $approvedQuery->avg('stars'), 1) : 0.0;

        $distribution = Rating::approved()
            ->select('stars', DB::raw('COUNT(*) as total'))
            ->groupBy('stars')
            ->pluck('total', 'stars');

        $ratingStats = collect(range(5, 1))->mapWithKeys(function ($stars) use ($distribution, $totalApproved) {
            $count = (int) ($distribution[$stars] ?? 0);
            $percentage = $totalApproved > 0 ? round(($count / $totalApproved) * 100) : 0;
            return [$stars => ['count' => $count, 'percentage' => $percentage]];
        });

        $statusCounts = Rating::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $products = Product::orderBy('name')->get(['id', 'name']);

        return view('admin.ratings.index', compact(
            'ratings',
            'status',
            'productId',
            'keyword',
            'averageRating',
            'totalApproved',
            'ratingStats',
            'statusCounts',
            'products'
        ));
    }

    public function updateStatus(Request $request, Rating $rating)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in([
                Rating::STATUS_PENDING,
                Rating::STATUS_APPROVED,
                Rating::STATUS_HIDDEN,
            ])],
        ]);

        $oldStatus = $rating->status;
        $rating->status = $data['status'];
        $rating->reviewed_at = now();
        $rating->save();

        // Gửi notification cho user khi đánh giá được duyệt
        if ($rating->status === Rating::STATUS_APPROVED && $oldStatus !== Rating::STATUS_APPROVED) {
            // Load quan hệ để notification có đủ thông tin
            $rating->load(['user', 'product']);
            
            if ($rating->user) {
                try {
                    $rating->user->notify(new RatingApprovedNotification($rating));
                    \Log::info('Rating approved notification sent to user', [
                        'user_id' => $rating->user->id,
                        'rating_id' => $rating->id
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Error sending rating approved notification', ['error' => $e->getMessage()]);
                }
            }
        }

        $message = match ($rating->status) {
            Rating::STATUS_APPROVED => 'Đánh giá đã được duyệt và hiển thị.',
            Rating::STATUS_HIDDEN => 'Đánh giá đã được ẩn.',
            default => 'Đánh giá đã được chuyển về trạng thái chờ duyệt.',
        };

        return Redirect::back()->with('success', $message);
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();

        return Redirect::back()->with('success', 'Đánh giá đã được xoá.');
    }
}
