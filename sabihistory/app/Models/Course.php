<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code', 'course_title', 'description', 'level', 
        'semester', 'credits', 'department', 'lecturer_id'
    ];

    // Relationships
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function pastQuestions()
    {
        return $this->hasMany(PastQuestion::class);
    }

    // Get all materials for this course by type
    public function getMaterialsByType($type)
    {
        return $this->materials()->where('type', $type)->get();
    }

    // Get all past questions with solutions
    public function getPastQuestionsWithSolutions()
    {
        return $this->pastQuestions()->whereNotNull('solution_pdf_path')->get();
    }
}