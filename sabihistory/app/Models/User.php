<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'matric_no', 'level', 'department', 'points', 'is_admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    // Relationships
    public function materials()
    {
        return $this->hasMany(Material::class, 'uploaded_by');
    }

    public function aiSessions()
    {
        return $this->hasMany(AiSession::class);
    }

    public function reviews()
    {
        return $this->hasMany(LecturerReview::class);
    }

    // Admin check - SINGLE VERSION (no duplicate)
    public function isAdmin()
    {
        return $this->is_admin == true || $this->role === 'admin';
    }

    // Super admin check
    public function isSuperAdmin()
    {
        return $this->email === 'admin@sabihistory.com';
    }

    // Role checks
    public function isLecturer()
    {
        return $this->role === 'lecturer';
    }

    // Scope for admin queries
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }
}