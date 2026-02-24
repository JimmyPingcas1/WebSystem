<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    public function index()
    {
        // Get tenants with their primary domain (if exists)
        $tenants = DB::table('tenants')
            ->leftJoin('tenant_domains', function($join) {
                $join->on('tenants.id', '=', 'tenant_domains.tenant_id')
                     ->where('tenant_domains.is_primary', true);
            })
            ->select(
                'tenants.*', 
                'tenant_domains.domain', 
                'tenant_domains.is_primary'
            )
            ->get();

        return view('tenant_seeders', compact('tenants'));
    }
}
