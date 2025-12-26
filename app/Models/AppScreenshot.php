<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppScreenshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_id',
        'image_path',
        'caption',
        'device_type',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function getImageUrl()
    {
        return asset('storage/' . $this->image_path);
    }
}
