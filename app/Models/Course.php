<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'image_path',
        'price',
        'duration',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Relationship: A course belongs to a category
     */
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    /**
     * Relationship: A course has many syllabuses
     */
    public function syllabus()
    {
        return $this->hasMany(CourseSyllabus::class, 'course_id');
    }

    /**
     * Scope: Featured courses
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Active courses
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
