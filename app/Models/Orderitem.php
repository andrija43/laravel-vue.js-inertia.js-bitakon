<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'prompt_id',
        'user_id',
        'amount',
        'created_at',
        'updated_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function prompt()
    {
        return $this->belongsTo(Prompt::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByAuthUser($query, $userId, $whereKey = 'prompts.user_id')
    {
        return $query->join('prompts', 'orderitems.prompt_id', '=', 'prompts.id')
            ->join('orders', 'orderitems.order_id', '=', 'orders.id')
            ->join('promptmodels', 'prompts.promptmodel_id', '=', 'promptmodels.id')
            ->join('users', 'orderitems.user_id', '=', 'users.id')
            ->where($whereKey, $userId);
    }
    public function scopeAllJoined($query)
    {
        return $query->join('prompts', 'orderitems.prompt_id', '=', 'prompts.id')
            ->join('orders', 'orderitems.order_id', '=', 'orders.id')
            ->join('promptmodels', 'prompts.promptmodel_id', '=', 'promptmodels.id')
            ->join('users', 'orderitems.user_id', '=', 'users.id');
    }
}
