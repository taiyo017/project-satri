<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id',
        'is_active',
        'order',
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class);
    }
}
