<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_score',
        'correct_count',
        'total_questions',
        'accuracy',
    ];

    protected $casts = [
        'total_score' => 'integer',
        'correct_count' => 'integer',
        'total_questions' => 'integer',
        'accuracy' => 'decimal:2',
    ];

    /**
     * Get the user that owns the score
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get percentage as integer
     */
    public function getPercentageAttribute()
    {
        return round($this->accuracy);
    }

    /**
     * Get grade letter based on accuracy
     */
    public function getGradeAttribute()
    {
        if ($this->accuracy >= 90) return 'A';
        if ($this->accuracy >= 80) return 'B';
        if ($this->accuracy >= 70) return 'C';
        if ($this->accuracy >= 60) return 'D';
        return 'E';
    }
}