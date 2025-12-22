<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionTopic extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class, 'subscriber_topics')
            ->withTimestamps()
            ->withPivot('subscribed_at');
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(EmailCampaign::class);
    }

    public function activeSubscribers(): BelongsToMany
    {
        return $this->subscribers()->where('status', 'active')->whereNotNull('verified_at');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
