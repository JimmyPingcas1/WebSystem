<?php

namespace App\Http\Controllers\Auth\tenantAuthController;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.tenantAuth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tenant_slug' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        // Find the tenant by slug
        $tenant = Tenant::where('slug', $request->tenant_slug)->first();
        
        if (!$tenant) {
            return back()->withInput($request->only('email', 'tenant_slug'))
                        ->withErrors(['tenant_slug' => 'Tenant not found']);
        }

        // Set the tenant database connection
        Config::set('database.connections.tenant.database', $tenant->database_name);
        DB::purge('tenant');

        // Send password reset link
        $status = Password::broker('tenants')->sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email', 'tenant_slug'))
                        ->withErrors(['email' => __($status)]);
    }
}

