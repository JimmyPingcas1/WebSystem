<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function admin(Request $request): RedirectResponse
    {
        auth('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.login'));
    }

    public function tenant(Request $request): RedirectResponse
    {
        $slug = session('tenant_slug');
        auth('tenant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect to tenant landing page if slug exists
        if ($slug) {
            return redirect('/' . $slug);
        }
        
        return redirect('/');
    }

    public function user(Request $request): RedirectResponse
    {
        $slug = session('tenant_slug');
        auth('regular_user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Redirect to tenant landing page if slug exists
        if ($slug) {
            return redirect('/' . $slug);
        }
        
        return redirect('/');
    }
}
