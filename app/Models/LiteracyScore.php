<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiteracyScore extends Model
{
    protected $fillable = ['user_id', 'category', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
