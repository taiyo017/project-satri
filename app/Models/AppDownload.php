<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id',
        'app_version_id',
        'platform',
        'source',
        'ip_address',
        'user_agent',
        'country_code',
        'country_name',
        'city',
        'device_type',
        'browser',
        'os',
        'referrer',
    ];

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function version()
    {
        return $this->belongsTo(AppVersion::class, 'app_version_id');
    }
}
