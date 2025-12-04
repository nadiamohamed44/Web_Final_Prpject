<?php
// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // تحقق إذا المستخدم مسجل ومش admin
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالدخول. يرجى تسجيل الدخول.'
            ], 401);
        }
        
        // تحقق إذا المستخدم admin
        if (auth()->user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح بالدخول. تحتاج صلاحيات مدير.'
            ], 403);
        }
        
        return $next($request);
    }
}