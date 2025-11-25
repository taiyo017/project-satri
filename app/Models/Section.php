<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    use HasFactory;
    protected $fillable = [
        'page_id',
        'title',
        'subtitle',
        'content',
        'image',
        'video_url',
        'button_text',
        'button_link',
        'order_index',
        'is_active',
        'section_type',
    ];
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function fields()
    {
        return $this->hasMany(SectionField::class)->orderBy('order_index');
    }
}
