<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_version_id',
        'platform',
        'file_type',
        'file_path',
        'external_url',
        'store_url',
        'file_size',
        'mime_type',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'file_size' => 'integer',
    ];

    public function version()
    {
        return $this->belongsTo(AppVersion::class, 'app_version_id');
    }

    public function getDownloadUrl()
    {
        if ($this->store_url) {
            return $this->store_url;
        }

        if ($this->external_url) {
            return $this->external_url;
        }

        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }

        return null;
    }

    public function getFormattedFileSize()
    {
        if (!$this->file_size) {
            return 'N/A';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }
}
