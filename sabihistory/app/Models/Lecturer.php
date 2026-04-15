<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'title', 'email', 'phone', 'department', 
        'office_location', 'bio', 'profile_image', 'average_rating'
    ];

    // Relationships
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function reviews()
    {
        return $this->hasMany(LecturerReview::class);
    }

    // Calculate and update average rating
    public function updateAverageRating()
    {
        $this->average_rating = $this->reviews()->avg('rating') ?? 0;
        $this->save();
    }

    // Get full name with title
    public function getFullNameAttribute()
    {
        return $this->title ? $this->title . ' ' . $this->name : $this->name;
    }
}