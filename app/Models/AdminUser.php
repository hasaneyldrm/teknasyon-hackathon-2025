<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'last_login_at',
        'last_login_ip'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isModerator(): bool
    {
        return in_array($this->role, ['moderator', 'admin', 'super_admin']);
    }

    public function updateLastLogin(string $ip): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip
        ]);
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    public function changeRole(string $role): void
    {
        if (in_array($role, ['moderator', 'admin', 'super_admin'])) {
            $this->update(['role' => $role]);
        }
    }

    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    public function canManageAdmins(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canViewLogs(): bool
    {
        return $this->isModerator();
    }

    public function canManageSecurity(): bool
    {
        return $this->isAdmin();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}
