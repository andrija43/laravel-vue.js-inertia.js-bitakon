<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;

    protected $guarded = [];

  
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promptmodel()
    {
        return $this->belongsTo(Promptmodel::class);
    }
    public function category()
    {
        return $this->belongsTo(Promptcategory::class, 'promptcategory_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Promptlike::class, 'prompt_id', 'id');
    }

    public function visits()
    {
        return $this->hasMany(Visitor::class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function slider()
    {
        return $this->hasOne(Slider::class);
    }

    public function orders()
    {
        return $this->hasMany(Orderitem::class);
    }
}
