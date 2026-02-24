<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant;
use App\Models\TenantModel\Tenant as TenantUser;

class TenantLoginController extends Controller
{
    /**
     * Show tenant login page.
     */
    public function create(): View
    {
        return view('auth.tenantAuth.login');
    }

    /**
     * Handle tenant login.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'tenant_slug' => 'required|string',
        ]);

        // 1️⃣ Find the tenant by slug from central database
        $tenant = Tenant::where('slug', $request->tenant_slug)->first();
        if (!$tenant) {
            return back()->withErrors(['tenant_slug' => 'Tenant not found'])->onlyInput('tenant_slug');
        }

        // 2️⃣ Dynamically set tenant database connection
        config(['database.connections.tenant.database' => $tenant->database_name]);
        DB::purge('tenant');

        // 3️⃣ Run migrations if tenant tables don't exist
        if (!Schema::connection('tenant')->hasTable('tenant_users')) {
            try {
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/tenant',
                    '--database' => 'tenant',
                    '--force' => true,
                ]);
            } catch (\Exception $e) {
                return back()->withErrors([
                    'tenant_slug' => 'Tenant database not ready: ' . $e->getMessage()
                ])->onlyInput('tenant_slug');
            }
        }

        // 4️⃣ Query the tenant database directly to find user
        $userRecord = DB::connection('tenant')
            ->table('tenant_users')
            ->where('email', $request->email)
            ->first();
        
        if (!$userRecord) {
            return back()->withErrors([
                'email' => 'The provided credentials are invalid.'
            ])->onlyInput('email');
        }

        // 5️⃣ Verify password hash
        if (!Hash::check($request->password, $userRecord->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials are invalid.'
            ])->onlyInput('email');
        }

        // 6️⃣ Create user model instance with correct connection
        $user = new TenantUser();
        $user->setConnection('tenant');
        $user->forceFill((array) $userRecord);

        // 7️⃣ Log the user in
        Auth::guard('tenant')->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Store tenant info in session
        $request->session()->put('tenant_database', $tenant->database_name);
        $request->session()->put('tenant_slug', $tenant->slug);

        // 8️⃣ Redirect to tenant's slug-based dashboard
        return redirect('/' . $tenant->slug . '/dashboard');
    }
}
