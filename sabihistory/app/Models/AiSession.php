<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'query',
        'response',
        'query_type',
        'related_material_ids',
        'tokens_used',
    ];

    protected $casts = [
        'related_material_ids' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
