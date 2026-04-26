<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_name',
        'matric_no',
        'department',
        'level',
        'year_completed',
        'abstract',
        'file_path',
        'downloads',
        'uploaded_by',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'year_completed' => 'integer',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function incrementDownloads()
    {
        $this->increment('downloads');
    }
}