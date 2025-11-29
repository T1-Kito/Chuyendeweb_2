<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        // Validate pagination parameter
        $perPage = $request->input('per_page', 20);
        if (!is_numeric($perPage) || $perPage < 1 || $perPage > 100) {
            $perPage = 20;
        }
        
        // Phân trang, mới nhất lên trên, load quan hệ user+product
        // Chỉ lấy comments gốc (không có parent_id)
        $comments = Comment::with(['user','product', 'replies.user'])
            ->whereNull('parent_id')
            ->orderByDesc('created_at')
            ->paginate((int)$perPage)
            ->withQueryString(); // Giữ lại query string khi phân trang
        
        return view('admin.comments.index', compact('comments'));
    }

    public function reply(Request $request, $id)
    {
        try {
            // Tìm comment gốc
            $parentComment = Comment::find($id);
            
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
                'product_id' => $parentComment->product_id,
                'user_id' => auth()->id(),
                'parent_id' => $parentComment->id,
                'content' => $content,
            ]);

            // Load quan hệ
            $reply->load(['user', 'product']);

            // Gửi notification cho user đã bình luận (nếu không phải chính họ)
            if ($parentComment->user_id != auth()->id()) {
                try {
                    $parentComment->user->notify(new \App\Notifications\NewCommentNotification($reply));
                } catch (\Exception $e) {
                    \Log::error('Error sending reply notification', ['error' => $e->getMessage()]);
                }
            }

            return back()->with('success', 'Đã trả lời bình luận thành công.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error replying to comment', [
                'error' => $e->getMessage(),
                'comment_id' => $id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi trả lời bình luận. Vui lòng thử lại.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            // Tìm comment theo ID thay vì dùng route model binding để có thể xử lý lỗi tốt hơn
            $comment = Comment::find($id);
            
            // Kiểm tra xem comment có tồn tại không
            if (!$comment) {
                return back()->with('error', 'Bình luận này đã được xóa. Vui lòng tải lại trang.');
            }
            
            // Xóa tất cả notifications liên quan đến comment này và các replies
            $commentIds = [$comment->id];
            // Lấy tất cả reply IDs
            $replyIds = Comment::where('parent_id', $comment->id)->pluck('id')->toArray();
            $commentIds = array_merge($commentIds, $replyIds);
            
            // Xóa notifications
            $notifications = \DB::table('notifications')
                ->where('type', 'App\\Notifications\\NewCommentNotification')
                ->get();
            
            foreach ($notifications as $notification) {
                $data = json_decode($notification->data, true);
                if (isset($data['comment_id']) && in_array($data['comment_id'], $commentIds)) {
                    \DB::table('notifications')->where('id', $notification->id)->delete();
                }
            }
            
            // Xóa tất cả replies trước (cascade sẽ xử lý)
            Comment::where('parent_id', $comment->id)->delete();
            
            // Xóa comment
            $comment->delete();
            
            return back()->with('success', 'Đã xoá bình luận thành công.');
        } catch (\Exception $e) {
            \Log::error('Error deleting comment', [
                'error' => $e->getMessage(), 
                'comment_id' => $id ?? null,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi xóa bình luận. Vui lòng tải lại trang.');
        }
    }
}
