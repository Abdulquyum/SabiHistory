<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'lecturer_id',
        'user_id',
        'rating',
        'comment',
        'course_code',
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
