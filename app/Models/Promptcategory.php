<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promptcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'preview',
        'promptmodel_id',
        'slug',
        'status',
        'is_filterable',
        'meta',
    ];

    public function promptmodel()
    {
        return $this->belongsTo(Promptmodel::class);
    }

    public function prompts()
    {
        return $this->hasMany(Prompt::class);
    }
}
