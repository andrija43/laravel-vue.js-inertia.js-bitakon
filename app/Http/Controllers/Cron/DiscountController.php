<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Prompt;

class DiscountController extends Controller
{
    public function calculateDiscount()
    {
        $discounts = Discount::query()->where('will_expire', '<', today());
        $discounts->get()->each(function ($discount) {
            $prompt = Prompt::findOrFail($discount->prompt_id);
            $prompt->update([
                'price' => round($prompt->price / (1 - ($discount->percentage / 100)))
            ]);
        });
        $discounts->delete();
        return "discount calculated";
    }
}
