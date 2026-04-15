<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'matric_no', 'level', 'department', 'points'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
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

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isLecturer()
    {
        return $this->role === 'lecturer';
    }
}