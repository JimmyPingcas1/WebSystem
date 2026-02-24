<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantModel\Tenant as TenantUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class TenantRegisterController extends Controller
{
    /**
     * Show tenant registration page.
     */
    public function create(): View
    {
        return view('auth.tenantAuth.register');
    }

    /**
     * Handle an incoming tenant registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'tenant_name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'lowercase', 'max:255', 'alpha_dash', 'unique:tenants,slug'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1️⃣ Create new tenant in central database
        $tenantSlug = $request->slug;
        $tenantDatabaseName = 'tenant_' . str_replace('-', '_', $tenantSlug);

        $tenant = Tenant::create([
            'tenant_name' => $request->tenant_name,
            'slug' => $tenantSlug,
            'database_name' => $tenantDatabaseName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2️⃣ Create tenant database and run migrations
        try {
            // Create database
            DB::connection('mysql')->statement('CREATE DATABASE IF NOT EXISTS `' . $tenantDatabaseName . '`');

            // Switch connection to new tenant database
            config(['database.connections.tenant.database' => $tenantDatabaseName]);
            DB::purge('tenant');

            // Run migrations for tenant
            Artisan::call('migrate', [
                '--path' => 'database/migrations/tenant',
                '--database' => 'tenant',
                '--force' => true,
            ]);
        } catch (\Exception $e) {
            // Rollback tenant creation
            $tenant->delete();
            return back()->withErrors(['error' => 'Failed to create tenant database: ' . $e->getMessage()]);
        }

        // 3️⃣ Create admin user in tenant database
        try {
            $adminUser = DB::connection('tenant')->table('tenant_users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Fetch the created user
            $userRecord = DB::connection('tenant')
                ->table('tenant_users')
                ->where('id', $adminUser)
                ->first();

            // Create model instance
            $user = new TenantUser();
            $user->setConnection('tenant');
            $user->forceFill((array) $userRecord);

            // Fire registered event
            event(new Registered($user));

            // Log the user in
            Auth::guard('tenant')->login($user);
            $request->session()->regenerate();

            // Store tenant info in session
            $request->session()->put('tenant_database', $tenantDatabaseName);
            $request->session()->put('tenant_slug', $tenantSlug);

            // Redirect to tenant's dashboard
            return redirect('/' . $tenantSlug . '/dashboard');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create admin user: ' . $e->getMessage()]);
        }
    }
}
