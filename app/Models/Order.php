<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_no',
    ];

    protected $casts = [
        'meta' => 'json'
    ];

    protected $appends = ['created_at_diff', 'amountFormat','taxFormat'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Order::max('id') + 1;
            $model->invoice_no = str_pad($model->id, 7, '0', STR_PAD_LEFT);
        });
    }
    public function getAmountFormatAttribute()
    {
        return amount_format($this->amount);
    }
    public function gettaxFormatAttribute()
    {
        return amount_format($this->tax);
    }
    public function getCreatedAtDiffAttribute()
    {
        return $this->created_at != null ? $this->created_at->diffForHumans() : '';
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function items()
    {
        return $this->hasMany(Orderitem::class);
    }

    public function gateway()
    {
        return $this->belongsTo('App\Models\Gateway');
    }
}
