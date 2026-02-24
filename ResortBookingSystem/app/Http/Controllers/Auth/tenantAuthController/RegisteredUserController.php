<?php

namespace App\Http\Controllers\Auth\tenantAuthController;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantDomain;
use App\Models\TenantModel\Tenant as TenantUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the tenant registration view.
     */
    public function create(): View
    {
        return view('auth.tenantAuth.register');
    }

    /**
     * Handle tenant registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1️⃣ Validate tenant & admin inputs
        $request->validate([
            'tenant_name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9-]+$/', 'unique:tenants,slug'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2️⃣ Generate database name and domain
        $tenantId = Str::random(12);
        $databaseName = $this->generateDatabaseName($tenantId);
        $domain = $this->generateDomainFromSlug($request->slug);

        // 3️⃣ Create Tenant record in root database
        $tenant = Tenant::create([
            'tenant_name' => $request->tenant_name,
            'slug' => $request->slug,
            'database_name' => $databaseName,
            'metadata' => [],
        ]);

        // 4️⃣ Create domain entry
        TenantDomain::create([
            'tenant_id' => $tenant->id,
            'domain' => $domain,
            'is_primary' => true,
        ]);

        // 5️⃣ Create the actual tenant database using raw SQL
        DB::statement("CREATE DATABASE IF NOT EXISTS `{$databaseName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        // 6️⃣ Switch to tenant database
        config(['database.connections.tenant.database' => $databaseName]);
        DB::purge('tenant');

        // 7️⃣ Run tenant migrations
        $this->runTenantMigrations();

        // 8️⃣ Create first tenant admin/staff user in tenant DB using Eloquent
        $admin = new \App\Models\TenantModel\Tenant();
        $admin->setConnection('tenant');
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->role = 'admin';
        $admin->save();

        // 9️⃣ Log in the tenant user (from tenant DB)
        Auth::guard('tenant')->setProvider(app('auth')->createUserProvider('tenants'));
        Auth::guard('tenant')->login($admin);

        // 🔟 Redirect to tenant dashboard using slug
        return redirect()->route('tenant.dashboard', ['tenant_slug' => $request->slug]);
    }

    /**
     * Generate database name from tenant ID.
     */
    private function generateDatabaseName(string $tenantId): string
    {
        $prefix = config('tenancy.database.prefix', 'tenant_');
        $suffix = config('tenancy.database.suffix', '');
        return $prefix . $tenantId . $suffix;
    }

    /**
     * Generate domain from slug.
     */
    private function generateDomainFromSlug(string $slug): string
    {
        $baseDomain = $slug;
        $domain = $baseDomain;
        $counter = 1;
        $tld = config('tenancy.tld', 'test');

        while (TenantDomain::where('domain', $domain . '.' . $tld)->exists()) {
            $domain = $baseDomain . $counter;
            $counter++;
        }

        return $domain . '.' . $tld;
    }

    /**
     * Run migrations in the tenant database.
     */
    private function runTenantMigrations(): void
    {
        \Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations/tenant',
        ]);
    }
}

