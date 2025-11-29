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
        $comments = Comment::with(['user','product'])
            ->orderByDesc('created_at')
            ->paginate((int)$perPage)
            ->withQueryString(); // Giữ lại query string khi phân trang
        
        return view('admin.comments.index', compact('comments'));
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
