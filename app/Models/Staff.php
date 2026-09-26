<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'staff';
    protected $primaryKey = 'Sid';

    protected $fillable = [
        'UserName',
        'Password',
        'Role',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'Password' => 'hashed',
        ];
    }

    /**
     * Get the password for the authenticatable model.
     */
    public function getAuthPassword()
    {
        return $this->Password;
    }

    /**
     * Get the name of the unique identifier for the user.
     */
    public function getAuthIdentifierName()
    {
        return 'Sid';
    }

    /**
     * Check if staff is an Admin.
     */
    public function isAdmin(): bool
    {
        return strtolower($this->Role) === 'admin';
    }

    /**
     * Check if staff is a Stock controller.
     */
    public function isStock(): bool
    {
        return strtolower($this->Role) === 'stock';
    }

    /**
     * Check if staff has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return strtolower($this->Role) === strtolower($role);
    }
}
