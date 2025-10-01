<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'employee_id',
        'last_login_at',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    // =================== Relationships ===================
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // =================== Scopes ===================
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // =================== Helper Methods ===================
    
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isItAdmin()
    {
        return $this->role === 'it_admin';
    }

    public function isEmployee()
    {
        return $this->role === 'employee';
    }

    public function hasAdminPrivileges()
    {
        return in_array($this->role, ['super_admin', 'it_admin']);
    }

    public function getFullNameAttribute()
    {
        if ($this->employee) {
            return $this->employee->name_th . ' ' . $this->employee->surname_th;
        }
        return $this->name;
    }

    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
    }
}