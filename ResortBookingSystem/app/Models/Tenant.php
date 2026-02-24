<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

class Tenant extends Authenticatable
{
    use HasFactory, Notifiable, CanResetPassword;

    protected $table = 'tenants';

    protected $fillable = [
        'tenant_name',
        'slug',
        'database_name',
        'email',
        'password',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
    ];

    /**
     * Get the domains associated with this tenant.
     */
    public function domains(): HasMany
    {
        return $this->hasMany(TenantDomain::class);
    }

    /**
     * Get the primary domain for this tenant.
     */
    public function primaryDomain()
    {
        return $this->domains()->where('is_primary', true)->first();
    }
}
