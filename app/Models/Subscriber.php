<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'email',
        'name',
        'verification_token',
        'verified_at',
        'status',
        'unsubscribe_token',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscriber) {
            if (empty($subscriber->verification_token)) {
                $subscriber->verification_token = Str::random(64);
            }
            if (empty($subscriber->unsubscribe_token)) {
                $subscriber->unsubscribe_token = Str::random(64);
            }
        });
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(SubscriptionTopic::class, 'subscriber_topics')
            ->withTimestamps()
            ->withPivot('subscribed_at');
    }

    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class);
    }

    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->isVerified();
    }

    public function verify(): void
    {
        $this->update([
            'verified_at' => now(),
            'status' => 'active',
        ]);
    }

    public function unsubscribe(): void
    {
        $this->update(['status' => 'unsubscribed']);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->whereNotNull('verified_at');
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }
}
