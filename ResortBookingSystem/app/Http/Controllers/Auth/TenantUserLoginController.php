<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TenantUserModel\RegularUser;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantUserLoginController extends Controller
{
    /**
     * Show tenant user login page.
     */
    public function create(): View
    {
        return view('auth.tenantUserAuth.login');
    }

    /**
     * Handle tenant user login.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Get tenant slug from route
        $slug = $request->route('tenant_slug');
        if (!$slug) {
            return back()->withErrors(['email' => 'Invalid tenant']);
        }

        // Query the tenant database directly to find user
        $userRecord = DB::connection('tenant')
            ->table('regular_users')
            ->where('email', $request->email)
            ->first();
        
        if (!$userRecord) {
            return back()->withErrors([
                'email' => 'The provided credentials are invalid.'
            ])->onlyInput('email');
        }

        // Verify password hash
        if (!Hash::check($request->password, $userRecord->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials are invalid.'
            ])->onlyInput('email');
        }

        // Create user model instance with correct connection
        $user = new RegularUser();
        $user->setConnection('tenant');
        $user->forceFill((array) $userRecord);

        // Log the user in
        Auth::guard('regular_user')->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Store tenant info in session
        $request->session()->put('tenant_slug', $slug);

        // Redirect to tenant user's dashboard
        return redirect('/' . $slug . '/user/dashboard');
    }
}
