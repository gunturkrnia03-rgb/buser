<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'content',
        'image',
        'source',
        'explanation',
        'likes',
        'shares',
    ];

    protected $casts = [
        'type' => 'string',
        'likes' => 'integer',
        'shares' => 'integer',
    ];

    /**
     * Scope untuk filter hoaks
     */
    public function scopeHoaks($query)
    {
        return $query->where('type', 'hoaks');
    }

    /**
     * Scope untuk filter fakta
     */
    public function scopeFakta($query)
    {
        return $query->where('type', 'fakta');
    }

    /**
     * Get badge warna berdasarkan type
     */
    public function getBadgeClassAttribute()
    {
        return $this->type === 'hoaks' ? 'red' : 'green';
    }
}