<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'meta' => 'json'
    ];

    public function prompt()
    {
        return $this->belongsTo(Prompt::class);
    }
}
