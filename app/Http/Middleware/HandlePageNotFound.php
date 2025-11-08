<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\Paginator;

class HandlePageNotFound
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Kiểm tra nếu là lỗi 404 và có thể là do trang phân trang không tồn tại
        if ($response->getStatusCode() === 404) {
            $url = $request->url();
            
            // Kiểm tra nếu URL chứa tham số page
            if (strpos($url, 'page=') !== false) {
                // Lấy URL gốc không có tham số page
                $baseUrl = preg_replace('/[?&]page=\d+/', '', $url);
                $baseUrl = rtrim($baseUrl, '?&');
                
                // Redirect về trang đầu tiên
                return redirect($baseUrl)->with('error', 'Trang không tồn tại. Đã chuyển về trang đầu tiên.');
            }
        }
        
        return $response;
    }
}
