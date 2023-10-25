<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promptlike extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function prompt()
    {
        return $this->belongsTo(Prompt::class);
    }
}
