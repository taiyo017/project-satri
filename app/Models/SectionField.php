<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionField extends Model
{
    protected $fillable = [
        'section_id',
        'field_key',
        'field_type',
        'field_value',
        'order_index',
    ];
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
