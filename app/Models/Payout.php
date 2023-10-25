<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'invoice_no',
        'amount',
        'charge',
        'user_id',
        'commant',
        'meta',
        'currency',
        'payout_method_id',
    ];

    protected $appends = ['created_at_date','amount_with_currency'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Payout::max('id') + 1;
            $model->invoice_no = str_pad($model->id, 7, '0', STR_PAD_LEFT);
        });
    }

    public function getCreatedAtDateAttribute()
    {
        return $this->created_at->format('F d, Y'); 
    }

    function getAmountWithCurrencyAttribute() {
        return amount_format($this->amount); 
    }

    public function method()
    {
        return $this->belongsTo(PayoutMethod::class, 'payout_method_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
