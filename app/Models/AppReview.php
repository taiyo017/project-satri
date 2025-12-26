<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id',
        'reviewer_name',
        'reviewer_email',
        'rating',
        'review',
        'ip_address',
        'user_agent',
        'status',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
