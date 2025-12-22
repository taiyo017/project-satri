<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailCampaign extends Model
{
    protected $fillable = [
        'subscription_topic_id',
        'subject',
        'content',
        'status',
        'scheduled_at',
        'sent_at',
        'total_recipients',
        'sent_count',
        'failed_count',
        'metadata',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(SubscriptionTopic::class, 'subscription_topic_id');
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
            ->where('scheduled_at', '<=', now());
    }

    public function getOpenRateAttribute(): float
    {
        if ($this->sent_count === 0) {
            return 0;
        }
        
        $opened = $this->emailLogs()->whereNotNull('opened_at')->count();
        return round(($opened / $this->sent_count) * 100, 2);
    }

    public function getClickRateAttribute(): float
    {
        if ($this->sent_count === 0) {
            return 0;
        }
        
        $clicked = $this->emailLogs()->where('click_count', '>', 0)->count();
        return round(($clicked / $this->sent_count) * 100, 2);
    }
}
