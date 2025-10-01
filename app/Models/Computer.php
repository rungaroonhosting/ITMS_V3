<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'asset_tag',
        'qr_code',
        'brand',
        'model',
        'serial_number',
        'specifications',
        'purchase_date',
        'warranty_expiry',
        'last_maintenance',
        'status',
        'assigned_to',
        'location',
        'qr_printed',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
        'last_maintenance' => 'date',
        'qr_printed' => 'boolean',
    ];

    /**
     * Boot method for auto-generation
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($computer) {
            // Auto-generate QR Code if not provided
            if (empty($computer->qr_code)) {
                $computer->qr_code = 'QR' . date('Ymd') . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // =================== Relationships ===================
    
    /**
     * Get the employee that owns the computer.
     */
    public function assignedTo()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    /**
     * Get incidents related to this computer.
     */
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    // =================== Scopes ===================
    
    /**
     * Scope for active computers
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for computers by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for assigned computers
     */
    public function scopeAssigned($query)
    {
        return $query->whereNotNull('assigned_to');
    }

    /**
     * Scope for unassigned computers
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    // =================== Helper Methods ===================
    
    /**
     * Check if computer is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if computer is assigned
     */
    public function isAssigned()
    {
        return !is_null($this->assigned_to);
    }

    /**
     * Get warranty status
     */
    public function getWarrantyStatusAttribute()
    {
        if (!$this->warranty_expiry) {
            return 'unknown';
        }
        
        if ($this->warranty_expiry->isPast()) {
            return 'expired';
        }
        
        if ($this->warranty_expiry->diffInDays() <= 30) {
            return 'expiring_soon';
        }
        
        return 'valid';
    }

    /**
     * Get days until warranty expiry
     */
    public function getDaysUntilWarrantyExpiryAttribute()
    {
        if (!$this->warranty_expiry) {
            return null;
        }
        
        return now()->diffInDays($this->warranty_expiry, false);
    }

    /**
     * Get full computer info
     */
    public function getFullInfoAttribute()
    {
        return $this->brand . ' ' . $this->model . ' (' . $this->asset_tag . ')';
    }

    /**
     * Generate QR Code URL
     */
    public function getQrCodeUrlAttribute()
    {
        return route('computers.show', $this->qr_code);
    }

    /**
     * Mark QR code as printed
     */
    public function markQrAsPrinted()
    {
        $this->update(['qr_printed' => true]);
    }
}