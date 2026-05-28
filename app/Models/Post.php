<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'content',
        'author_name',
        'image_path',
        'is_hoax',
        'explanation',
        'source_link',
        'category',
    ];
}
