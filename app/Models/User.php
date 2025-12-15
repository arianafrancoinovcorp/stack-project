<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class)
        ->withPivot('role')
        ->withTimestamps();
    }

    public function ownedTenants()
    {
        return $this->hasMany(Tenant::class, 'owner_id');
    }
   
    public function hasAccessToTenant($tenantId)
    {
        return $this->tenants()->where('tenant_id', $tenantId)->exists();
    }

    
    public function isOwnerOf($tenantId)
    {
        return $this->tenants()
            ->where('tenant_id', $tenantId)
            ->wherePivot('role', 'owner')
            ->exists();
    }

   
    public function isAdminOf($tenantId)
    {
        return $this->tenants()
            ->where('tenant_id', $tenantId)
            ->wherePivot('role', 'admin')
            ->exists();
    }

    
    public function roleInTenant($tenantId)
    {
        $tenant = $this->tenants()->where('tenant_id', $tenantId)->first();
        return $tenant?->pivot->role;
    }

    
    public function canManageTenant($tenantId)
    {
        return $this->isOwnerOf($tenantId) || $this->isAdminOf($tenantId);
    }
}
