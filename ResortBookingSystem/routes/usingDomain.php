<?php

use Illuminate\Support\Facades\Route;
use App\Models\TenantDomain;

/**
 * Domain-based tenant routing
 * 
 * Allows accessing tenant via domain like: tenant_1.localhost
 * Routes are automatically redirected to slug-based URLs
 */

// Catch all requests to tenant subdomains
Route::domain('{tenant_domain}.' . env('APP_DOMAIN', 'localhost'))
    ->middleware(['web'])
    ->group(function () {
        
        // Find tenant by domain and redirect to slug-based landing page
        Route::get('/', function ($tenant_domain) {
            // Find tenant by domain
            $domain = TenantDomain::where('domain', $tenant_domain . '.' . env('APP_DOMAIN', 'localhost'))
                ->with('tenant')
                ->first();
            
            if (!$domain || !$domain->tenant) {
                abort(404, 'Tenant not found');
            }
            
            // Redirect to slug-based landing page
            return redirect('/' . $domain->tenant->slug);
        });

        // Redirect any domain/path to slug-based equivalent
        Route::get('/{path}', function ($tenant_domain, $path) {
            $domain = TenantDomain::where('domain', $tenant_domain . '.' . env('APP_DOMAIN', 'localhost'))
                ->with('tenant')
                ->first();
            
            if (!$domain || !$domain->tenant) {
                abort(404, 'Tenant not found');
            }
            
            // Redirect to slug-based URL with path
            return redirect('/' . $domain->tenant->slug . '/' . $path);
        })->where('path', '.*');
    });
