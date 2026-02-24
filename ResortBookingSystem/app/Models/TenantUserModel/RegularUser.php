<?php

namespace App\Models\TenantUserModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\TenantUserPasswordReset;

class RegularUser extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\RegularUserFactory> */
    use HasFactory, Notifiable, CanResetPassword;

    protected $connection = 'tenant';
    protected $table = 'regular_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

        $this->notify(new TenantUserPasswordReset($token, $tenantSlug));
    }
}

