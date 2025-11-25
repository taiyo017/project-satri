<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'career_id',
        'name',
        'email',
        'phone',
        'resume',
        'cover_letter',
        'message',
        'is_read',
    ];

    /**
     * The career this application belongs to
     */
    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    /**
     * Mark this application as read
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->is_read = true;
            $this->save();
        }
    }

    /**
     * Scope to get unread applications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
