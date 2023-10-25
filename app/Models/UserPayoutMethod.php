<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayoutMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payout_infos',
        'payout_method_id',
    ];
}
