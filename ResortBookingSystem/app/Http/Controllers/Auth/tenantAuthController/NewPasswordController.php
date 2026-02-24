<?php

namespace App\Http\Controllers\Auth\tenantAuthController;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantModel\Tenant as TenantUser;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.tenantAuth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'tenant_slug' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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

        // Reset the password
        $status = Password::broker('tenants')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (TenantUser $tenantUser) use ($request) {
                $tenantUser->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($tenantUser));
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('tenant.select.login')->with('status', __($status))
                    : back()->withInput($request->only('email', 'tenant_slug'))
                        ->withErrors(['email' => __($status)]);
    }
}

