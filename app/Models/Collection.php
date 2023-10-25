<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prompts()
    {
        return $this->hasMany(Prompt::class);
    }

    public function prompt_previews()
    {
        return $this->hasMany(Prompt::class)->select('id', 'collection_id', 'preview')
            ->whereNotNull('preview')->inRandomOrder()->limit(36);
    }
}
