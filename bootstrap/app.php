<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'permission' => \App\Http\Middleware\CheckAdminPermission::class,
            'handle.page.not.found' => \App\Http\Middleware\HandlePageNotFound::class,
        ]);
        
        // Thêm middleware global để xử lý lỗi trang không tồn tại
        $middleware->web(append: [
            \App\Http\Middleware\HandlePageNotFound::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Xử lý riêng lỗi CSRF/419 để không hiển thị trang lỗi mặc định
        $exceptions->renderable(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            // Nếu là request tới trang đăng nhập thì quay về login với thông báo dễ hiểu
            if ($request->is('login')) {
                return redirect()
                    ->route('login')
                    ->with('error', 'Phiên đăng nhập đã hết hạn hoặc bạn bấm quá nhanh. Vui lòng thử đăng nhập lại.');
            }

            // Các form khác có thể xử lý tương tự nếu cần, còn lại để Laravel xử lý mặc định
            return null; // cho phép pipeline render mặc định tiếp tục
        });
    })->create();
