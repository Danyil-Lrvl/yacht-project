<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    /**
     * Показ головної сторінки з модальним вікном входу
     */
    public function showLoginForm()
    {
        return view('admin.index');
    }

    public function login(Request $request)
    {
        $adminPassword = env('ADMIN_PASSWORD', 'H11Gfi');
        
        if (empty($adminPassword)) {
            throw new \Exception('CRITICAL: ADMIN_PASSWORD is not defined in environment variables.');
        }

        if ($request->password === $adminPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.rent');
        }
        return back()->withErrors(['password' => 'Невірний пароль!']);
    }

    public function checkPassword(Request $request)
    {
        $adminPassword = env('ADMIN_PASSWORD', 'H11Gfi');
        
        if (empty($adminPassword)) {
            return response()->json(['success' => false, 'message' => 'Admin password not configured'], 500);
        }

        if ($request->password === $adminPassword) {
            session(['admin_logged_in' => true]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        session()->flush();
        return redirect()->route('admin.rent');
    }
}