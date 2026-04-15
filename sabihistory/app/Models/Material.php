<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'type', 'file_path', 'external_url', 
        'thumbnail', 'course_id', 'uploaded_by', 'level', 'downloads', 
        'views', 'upvotes', 'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Increment download count
    public function incrementDownloads()
    {
        $this->increment('downloads');
    }

    // Increment view count
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Get file URL (either local or external)
    public function getFileUrlAttribute()
    {
        if ($this->type === 'link' || $this->type === 'googledrive') {
            return $this->external_url;
        }
        return asset('storage/' . $this->file_path);
    }

    // Scope for approved materials only
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Search scope
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('title', 'LIKE', "%{$searchTerm}%")
                     ->orWhere('description', 'LIKE', "%{$searchTerm}%");
    }
}