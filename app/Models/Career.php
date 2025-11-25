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
        'job_type',
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
     * Get job type label
     */
    public function getJobTypeLabelAttribute(): string
    {
        return ucfirst(str_replace('-', ' ', $this->job_type));
    }
}
