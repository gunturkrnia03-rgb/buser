<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'answer',
        'is_correct',
        'time_spent',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'time_spent' => 'integer',
    ];

    /**
     * Get the user that owns the answer
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz that was answered
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}