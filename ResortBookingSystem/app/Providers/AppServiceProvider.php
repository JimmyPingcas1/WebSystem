<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register view namespaces for role-specific components and layouts
        view()->addNamespace('admin', resource_path('views/admin'));
        view()->addNamespace('tenant', resource_path('views/Tenant'));
        view()->addNamespace('tenant-user', resource_path('views/TenantUser'));
        // Register anonymous component namespaces so tags like
        // <x-admin::guest-layout> map to resources/views/admin/components/guest-layout.blade.php
        Blade::anonymousComponentNamespace(resource_path('views/admin/components'), 'admin');
        Blade::anonymousComponentNamespace(resource_path('views/Tenant/components'), 'tenant');
        Blade::anonymousComponentNamespace(resource_path('views/TenantUser/components'), 'tenant-user');
    }


}
