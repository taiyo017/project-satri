<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'icon',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'is_featured',
        'status'
    ];


    protected static function booted()
    {
        static::creating(function ($service) {
            if (!$service->slug) {
                $service->slug = Str::slug($service->title);
            }
        });
    }
}
