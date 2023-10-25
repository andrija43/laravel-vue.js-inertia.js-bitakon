<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promptmodel extends Model
{
    use HasFactory;
    protected $casts = [
        'meta' => 'json'
    ];

    protected $appends = ['created_at_diff', 'created_at_date', 'posturl'];

    public function getCreatedAtDiffAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getCreatedAtDateAttribute()
    {
        return $this->created_at->format('F d, Y');
    }

    public function getPosturlAttribute()
    {
        return url('/model', $this->slug);
    }

    public function model()
    {
        return $this->belongsTo(Promptmodel::class, 'promptmodel_id');
    }

    public function prompts()
    {
        return $this->hasMany(Prompt::class);
    }

    public function promptsrelation()
    {
        return $this->hasMany(Promptmodelrelation::class);
    }

    public function groups()
    {
        return $this->hasMany(Promptmodel::class)->where('type', 'prompt_group');
    }

    public function submodels()
    {
        return $this->hasMany(Promptmodel::class)->where('type', 'sub_models');
    }

    
}
