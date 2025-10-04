<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // Basic Information
        'employee_code',
        'first_name_th',
        'last_name_th',
        'first_name_en',
        'last_name_en',
        'nickname',
        
        // Contact Information
        'email',
        'login_email',
        'phone',
        
        // Personal Information
        'birth_date',
        'gender',
        'address',
        
        // Employment Information
        'department_id',
        'position_id',
        'branch_id',
        'supervisor_id',
        'hire_date',
        'termination_date',
        
        // System Access
        'role',
        'status',
        'password',
        
        // Additional Passwords
        'computer_password',
        'email_password',
        
        // Express System
        'express_username',
        'express_password',
        
        // Permissions
        'vpn_access',
        'color_printing',
        'remote_work',
        'admin_access',
        
        // Photo
        'photo',
        
        // Financial
        'salary',
        
        // Emergency Contact
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    protected $hidden = [
        'password',
        'computer_password',
        'email_password',
        'express_password',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'termination_date' => 'date',
        'salary' => 'decimal:2',
        'vpn_access' => 'boolean',
        'color_printing' => 'boolean',
        'remote_work' => 'boolean',
        'admin_access' => 'boolean',
    ];

    // ==================== Relationships ====================
    
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'supervisor_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'supervisor_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'employee_id');
    }

    // ==================== Accessors ====================
    
    public function getFullNameThAttribute(): ?string
    {
        if (!$this->first_name_th || !$this->last_name_th) {
            return null;
        }
        return $this->first_name_th . ' ' . $this->last_name_th;
    }

    public function getFullNameEnAttribute(): ?string
    {
        if (!$this->first_name_en || !$this->last_name_en) {
            return null;
        }
        return $this->first_name_en . ' ' . $this->last_name_en;
    }

    public function getNameAttribute(): string
    {
        return $this->full_name_th ?? $this->full_name_en ?? $this->email;
    }

    public function getHasPhotoAttribute(): bool
    {
        return !empty($this->photo);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) {
            return null;
        }
        
        if (Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
        }
        
        return null;
    }

    // ==================== Scopes ====================
    
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeByBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeWithExpress($query)
    {
        return $query->whereNotNull('express_username');
    }

    public function scopeWithoutExpress($query)
    {
        return $query->whereNull('express_username');
    }

    public function scopeWithPhoto($query)
    {
        return $query->whereNotNull('photo');
    }

    public function scopeWithoutPhoto($query)
    {
        return $query->whereNull('photo');
    }

    // ==================== Photo Management Methods ====================
    
    /**
     * Upload and save employee photo
     */
    public function uploadPhoto($file): ?string
    {
        try {
            // Delete old photo if exists
            if ($this->photo) {
                $this->deletePhoto();
            }

            // Generate filename
            $filename = 'employee_' . $this->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'employees/photos/' . $filename;

            // Store file
            $stored = Storage::disk('public')->put($path, file_get_contents($file));

            if ($stored) {
                $this->update(['photo' => $path]);
                return $path;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Photo upload failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete employee photo
     */
    public function deletePhoto(): bool
    {
        try {
            if ($this->photo && Storage::disk('public')->exists($this->photo)) {
                Storage::disk('public')->delete($this->photo);
            }
            
            $this->update(['photo' => null]);
            return true;
        } catch (\Exception $e) {
            Log::error('Photo deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get photo information
     */
    public function getPhotoInfo(): array
    {
        if (!$this->has_photo) {
            return [
                'has_photo' => false,
                'photo_url' => null,
                'photo_path' => null,
                'file_exists' => false,
            ];
        }

        $fileExists = Storage::disk('public')->exists($this->photo);

        return [
            'has_photo' => true,
            'photo_url' => $fileExists ? $this->photo_url : null,
            'photo_path' => $this->photo,
            'file_exists' => $fileExists,
            'file_size' => $fileExists ? Storage::disk('public')->size($this->photo) : 0,
            'updated_at' => $this->updated_at?->format('d/m/Y H:i:s'),
        ];
    }

    // ==================== Helper Methods ====================
    
    /**
     * Check if employee is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if employee is IT admin
     */
    public function isItAdmin(): bool
    {
        return $this->role === 'it_admin';
    }

    /**
     * Check if employee is HR
     */
    public function isHr(): bool
    {
        return $this->role === 'hr';
    }

    /**
     * Check if employee has Express account
     */
    public function hasExpressAccount(): bool
    {
        return !empty($this->express_username);
    }

    /**
     * Get role label in Thai
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'super_admin' => 'ผู้ดูแลระบบสูงสุด',
            'it_admin' => 'ผู้ดูแลระบบ IT',
            'hr' => 'ฝ่ายทรัพยากรบุคคล',
            'employee' => 'พนักงาน',
            'express' => 'พนักงาน Express',
            default => 'ไม่ระบุ',
        };
    }

    /**
     * Get status label in Thai
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'ใช้งาน',
            'inactive' => 'ไม่ใช้งาน',
            default => 'ไม่ระบุ',
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'inactive' => 'secondary',
            default => 'secondary',
        };
    }
}