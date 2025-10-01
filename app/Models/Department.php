<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // =================== Relationships ===================
    
    /**
     * Get the employees for the department.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Get active employees for the department.
     */
    public function activeEmployees()
    {
        return $this->hasMany(Employee::class)->where('is_active', true);
    }

    // =================== Scopes ===================
    
    /**
     * Scope for active departments
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // =================== Helper Methods ===================
    
    /**
     * Get employees count
     */
    public function getEmployeesCountAttribute()
    {
        return $this->employees()->count();
    }

    /**
     * Get active employees count
     */
    public function getActiveEmployeesCountAttribute()
    {
        return $this->activeEmployees()->count();
    }
}