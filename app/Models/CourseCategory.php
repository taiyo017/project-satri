<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Relationship: A category has many courses
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }

    /**
     * Scope: Active categories
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
