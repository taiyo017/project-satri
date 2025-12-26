<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id',
        'version_number',
        'version_code',
        'release_notes',
        'changelog',
        'is_latest',
        'status',
        'released_at',
    ];

    protected $casts = [
        'is_latest' => 'boolean',
        'released_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($version) {
            if ($version->is_latest) {
                static::where('app_id', $version->app_id)
                    ->update(['is_latest' => false]);
            }
        });

        static::updating(function ($version) {
            if ($version->is_latest && $version->isDirty('is_latest')) {
                static::where('app_id', $version->app_id)
                    ->where('id', '!=', $version->id)
                    ->update(['is_latest' => false]);
            }
        });
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function files()
    {
        return $this->hasMany(AppFile::class);
    }

    public function getFileForPlatform($platform)
    {
        return $this->files()->where('platform', $platform)->first();
    }
}
