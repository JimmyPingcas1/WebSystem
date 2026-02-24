<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Check the current route and redirect accordingly
            $path = $request->getPathInfo();
            
            // Admin routes - redirect to admin login
            if (str_starts_with($path, '/admin')) {
                return route('admin.login');
            }
            
            // Tenant user routes - redirect to tenant landing page
            $tenantSlug = $request->route('tenant_slug');
            if ($tenantSlug && str_contains($path, '/user/')) {
                return route('tenant.landing', ['tenant_slug' => $tenantSlug]);
            }
            
            // Tenant staff routes or any other - redirect to main landing page
            if ($tenantSlug) {
                return route('landing');
            }
            
            // Default - redirect to main landing page
            return route('landing');
        }

        return null;
    }
}
