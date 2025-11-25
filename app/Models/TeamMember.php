<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'bio',
        'photo',
        'social_links',
        'order_index',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}