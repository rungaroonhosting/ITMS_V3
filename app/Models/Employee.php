<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_code',
        'keycard_id',
        'name_th',
        'surname_th',
        'name_en',
        'surname_en',
        'nickname',
        'username_computer',
        'password_computer',
        'photocopy_code',
        'email',
        'email_password',
        'department_id',
        'express_username',
        'express_code',
        'can_print_color',
        'can_use_vpn',
        'is_active',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password_computer',
        'email_password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'can_print_color' => 'boolean',
        'can_use_vpn' => 'boolean',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Boot method for auto-generation
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($employee) {
            // Auto-generate username_computer
            if (empty($employee->username_computer) && $employee->name_en && $employee->surname_en) {
                $employee->username_computer = strtolower($employee->name_en . '.' . $employee->surname_en);
            }
            
            // Auto-generate password_computer
            if (empty($employee->password_computer)) {
                $employee->password_computer = Hash::make(self::generateRandomPassword(10));
            }
            
            // Auto-generate photocopy_code
            if (empty($employee->photocopy_code)) {
                $employee->photocopy_code = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            }
            
            // Auto-generate email
            if (empty($employee->email) && $employee->name_en && $employee->surname_en) {
                $employee->email = strtolower($employee->name_en . '.' . $employee->surname_en . '@company.com');
            }
            
            // Auto-generate email_password
            if (empty($employee->email_password)) {
                $employee->email_password = Hash::make(self::generateRandomPassword(10));
            }
            
            // Auto-generate express_username (7 chars)
            if (empty($employee->express_username)) {
                $employee->express_username = strtoupper(substr(uniqid(), -7));
            }
            
            // Auto-generate express_code (4 digits)
            if (empty($employee->express_code)) {
                $employee->express_code = str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // =================== Relationships ===================
    
    /**
     * Get the department that owns the employee.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the user associated with the employee.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get computers assigned to this employee.
     */
    public function computers()
    {
        return $this->hasMany(Computer::class, 'assigned_to');
    }

    /**
     * Get incidents reported by this employee.
     */
    public function incidents()
    {
        return $this->hasMany(Incident::class, 'reported_by');
    }

    /**
     * Get service requests made by this employee.
     */
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'requested_by');
    }

    /**
     * Get agreement acceptances by this employee.
     */
    public function agreementAcceptances()
    {
        return $this->hasMany(AgreementAcceptance::class);
    }

    // =================== Scopes ===================
    
    /**
     * Scope for active employees
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for employees by department
     */
    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    // =================== Helper Methods ===================
    
    /**
     * Get full name in Thai
     */
    public function getFullNameThAttribute()
    {
        return $this->name_th . ' ' . $this->surname_th;
    }

    /**
     * Get full name in English
     */
    public function getFullNameEnAttribute()
    {
        return $this->name_en . ' ' . $this->surname_en;
    }

    /**
     * Get display name (nickname or full name)
     */
    public function getDisplayNameAttribute()
    {
        return $this->nickname ?: $this->full_name_th;
    }

    /**
     * Generate random password
     */
    public static function generateRandomPassword($length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $password;
    }

    /**
     * Check if employee can print color
     */
    public function canPrintColor()
    {
        return $this->can_print_color;
    }

    /**
     * Check if employee can use VPN
     */
    public function canUseVpn()
    {
        return $this->can_use_vpn;
    }
}