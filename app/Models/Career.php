<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'job_category_id',
        'deadline',
        'is_open',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'deadline' => 'date',
    ];

    /**
     * Relationship: Career belongs to a job category
     */
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    /**
     * Relationship: Career has many applications
     */
    public function applications(): HasMany
    {
        return $this->hasMany(CareerApplication::class);
    }

    /**
     * Scope: Only open careers
     */
    public function scopeOpen($query)
    {
        return $query->where('is_open', true)
            ->where(function ($q) {
                $q->whereNull('deadline')
                    ->orWhere('deadline', '>=', now());
            });
    }

    /**
     * Get job type label (from category)
     */
    public function getJobTypeLabelAttribute(): string
    {
        return $this->jobCategory?->name ?? 'Uncategorized';
    }

    /**
     * Accessor for backward compatibility
     */
    public function getJobTypeAttribute()
    {
        return $this->jobCategory?->slug;
    }
}
