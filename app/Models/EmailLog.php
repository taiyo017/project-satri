<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class EmailLog extends Model
{
    protected $fillable = [
        'subscriber_id',
        'email_campaign_id',
        'subject',
        'type',
        'status',
        'tracking_token',
        'sent_at',
        'opened_at',
        'open_count',
        'click_count',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($log) {
            if (empty($log->tracking_token)) {
                $log->tracking_token = Str::random(64);
            }
        });
    }

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(EmailCampaign::class, 'email_campaign_id');
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(EmailClick::class);
    }

    public function markAsOpened(): void
    {
        if (is_null($this->opened_at)) {
            $this->opened_at = now();
        }
        $this->increment('open_count');
    }

    public function recordClick(string $url, ?string $ip = null, ?string $userAgent = null): void
    {
        $this->clicks()->create([
            'url' => $url,
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'clicked_at' => now(),
        ]);
        
        $this->increment('click_count');
    }
}
