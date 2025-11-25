<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSyllabus extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'file_path',
    ];

    /**
     * Relationship: A syllabus belongs to a course
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Helper: Check if a file is attached
     */
    public function hasFile()
    {
        return !empty($this->file_path);
    }
}
