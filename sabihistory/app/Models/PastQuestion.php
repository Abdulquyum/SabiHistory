<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'year', 'exam_type', 'question_pdf_path', 
        'solution_pdf_path', 'solution_text', 'downloads', 'uploaded_by'
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

    // Get question PDF URL
    public function getQuestionUrlAttribute()
    {
        return asset('storage/' . $this->question_pdf_path);
    }

    // Get solution PDF URL if exists
    public function getSolutionUrlAttribute()
    {
        if ($this->solution_pdf_path) {
            return asset('storage/' . $this->solution_pdf_path);
        }
        return null;
    }

    // Increment download count
    public function incrementDownloads()
    {
        $this->increment('downloads');
    }
}