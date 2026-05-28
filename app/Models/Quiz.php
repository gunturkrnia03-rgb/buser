<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'question',
        'image',
        'difficulty',
        'points',
        'explanation',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'points' => 'integer',
    ];

    /**
     * Get all answers for this quiz
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Scope untuk quiz aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope berdasarkan kesulitan
     */
    public function scopeDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Get difficulty badge color
     */
    public function getDifficultyColorAttribute()
    {
        return [
            'mudah' => 'green',
            'sedang' => 'yellow',
            'sulit' => 'red',
        ][$this->difficulty];
    }
}