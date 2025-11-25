<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'category',
        'order_index',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
}
