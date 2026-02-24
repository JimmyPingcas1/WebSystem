<?php

namespace App\Models\TenantModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\TenantPasswordReset;

class Tenant extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;

    // This model represents the **tenant staff/admin user inside tenant DB**
    protected $connection = 'tenant';
    protected $table = 'tenant_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // Get the tenant slug from the database configuration
        $tenantSlug = \DB::table('tenants')
            ->where('database_name', \DB::connection('tenant')->getDatabaseName())
            ->value('slug');

        $this->notify(new TenantPasswordReset($token, $tenantSlug));
    }
}
