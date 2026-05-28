<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'school',
        'password',
        'level',
        'total_score',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the answers for the user.
     * Relasi satu-ke-banyak dengan Answer
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * Get the scores for the user.
     * Relasi satu-ke-banyak dengan Score
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Get user's latest score
     */
    public function latestScore()
    {
        return $this->hasOne(Score::class)->latest();
    }

    /**
     * Calculate accuracy percentage
     */
    public function getAccuracyAttribute()
    {
        $totalAnswers = $this->answers()->count();
        if ($totalAnswers === 0) return 0;
        
        $correctAnswers = $this->answers()->where('is_correct', true)->count();
        return round(($correctAnswers / $totalAnswers) * 100, 2);
    }

    /**
     * Update user level based on total score
     */
    public function updateLevel()
    {
        if ($this->total_score >= 500) {
            $this->level = 'mahir';
        } elseif ($this->total_score >= 200) {
            $this->level = 'menengah';
        } else {
            $this->level = 'pemula';
        }
        $this->save();
    }
}