<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetTenantDatabase
{
    /**
     * Handle an incoming request.
     * Ensures the tenant connection has a database set before any tenant queries run.
     */
    public function handle(Request $request, Closure $next)
    {
        // Get tenant slug from route parameter
        $slug = $request->route('tenant_slug');
        
        // Reject "admin" as a tenant slug to prevent route conflict
        if ($slug === 'admin') {
            abort(404, 'Tenant not found');
        }
        
        // If slug is in URL, dynamically load tenant
        if ($slug) {
            $tenant = \App\Models\Tenant::where('slug', $slug)->first();
            
            if (!$tenant) {
                abort(404, 'Tenant not found');
            }
            
            // Set the database connection
            config(['database.connections.tenant.database' => $tenant->database_name]);
            config(['database.connections.tenant.host' => env('DB_HOST', '127.0.0.1')]);
            config(['database.connections.tenant.port' => env('DB_PORT', '3306')]);
            config(['database.connections.tenant.username' => env('DB_USERNAME', 'root')]);
            config(['database.connections.tenant.password' => env('DB_PASSWORD', '')]);
            
            // Purge the connection to force reconnection with new config
            DB::purge('tenant');
            
            // Reconnect to apply new configuration
            DB::reconnect('tenant');
            
            // Store in session for reference
            session(['tenant_database' => $tenant->database_name, 'tenant_slug' => $slug]);
        } else {
            // Fallback: try to recover from session
            $tenantDatabaseName = session('tenant_database');
            if (!$tenantDatabaseName && session('tenant_slug')) {
                $tenant = \App\Models\Tenant::where('slug', session('tenant_slug'))->first();
                if ($tenant) {
                    $tenantDatabaseName = $tenant->database_name;
                    session(['tenant_database' => $tenantDatabaseName]);
                }
            }

            if ($tenantDatabaseName) {
                config(['database.connections.tenant.database' => $tenantDatabaseName]);
                config(['database.connections.tenant.host' => env('DB_HOST', '127.0.0.1')]);
                config(['database.connections.tenant.port' => env('DB_PORT', '3306')]);
                config(['database.connections.tenant.username' => env('DB_USERNAME', 'root')]);
                config(['database.connections.tenant.password' => env('DB_PASSWORD', '')]);
                DB::purge('tenant');
                DB::reconnect('tenant');
            } elseif ($request->is('tenant/*')) {
                // On tenant routes with no database set: clear tenant auth so we never query the tenant
                // connection with an empty database (avoids "No database selected" when auth loads the user).
                Auth::guard('tenant')->logout();
            }
        }

        return $next($request);
    }
}
