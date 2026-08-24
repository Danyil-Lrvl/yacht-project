<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Перевіряємо, чи є в сесії позначка, що адмін увійшов
        if (!session()->has('admin_logged_in')) {
            // Якщо немає — перенаправляємо на сторінку логіну
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}