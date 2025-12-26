<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id',
        'token',
        'qr_code_path',
        'scan_count',
        'last_scanned_at',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'scan_count' => 'integer',
        'last_scanned_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($qrCode) {
            if (empty($qrCode->token)) {
                $qrCode->token = Str::random(32);
            }
        });
    }

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function incrementScanCount()
    {
        $this->increment('scan_count');
        $this->update(['last_scanned_at' => now()]);
        $this->app->incrementScanCount();
    }

    public function getQrCodeUrl()
    {
        if ($this->qr_code_path) {
            return asset('storage/' . $this->qr_code_path);
        }
        return null;
    }

    public function getScanUrl()
    {
        return route('apps.qr.scan', $this->token);
    }
}
