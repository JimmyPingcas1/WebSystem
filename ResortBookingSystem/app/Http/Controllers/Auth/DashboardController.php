<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;

class DashboardController
{
    public function adminIndex(): View
    {
        return view('admin.dashboard');
    }

    public function tenantIndex(): View
    {
        return view('Tenant.dashboard');
    }

    public function userIndex(): View
    {
        return view('TenantUser.dashboard');
    }
}
