<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class App extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'app_category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'icon',
        'package_name',
        'is_featured',
        'status',
        'download_count',
        'scan_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'download_count' => 'integer',
        'scan_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($app) {
            if (empty($app->slug)) {
                $app->slug = Str::slug($app->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(AppCategory::class, 'app_category_id');
    }

    public function versions()
    {
        return $this->hasMany(AppVersion::class)->orderBy('released_at', 'desc');
    }

    public function latestVersion()
    {
        return $this->hasOne(AppVersion::class)->where('is_latest', true);
    }

    public function screenshots()
    {
        return $this->hasMany(AppScreenshot::class)->orderBy('order');
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }

    public function reviews()
    {
        return $this->hasMany(AppReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(AppReview::class)->where('status', 'approved');
    }

    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    public function downloads()
    {
        return $this->hasMany(AppDownload::class);
    }

    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    public function incrementScanCount()
    {
        $this->increment('scan_count');
    }
}
