<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Inertia\Inertia;

class CronjobController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cron-job');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segments = request()->segments();

        $buttons = [];

        $jobs = [
            [
                'title' => __('Execute Schedule'),
                'url' => '* * * * * ' . base_path() . '/artisan schedule:run'
            ],
            [
                'title' => __('Calculate Sales Amount For Author'),
                'url' => 'curl -s ' . url('/cron/calculate-seller-order-payment'),
                'time' => __('Every minute')
            ],
            [
                'title' => __('Calculate Discounted Price'),
                'url' => 'curl -s ' . url('/cron/calculate-discounted-price'),
                'time' => __('Every Day (Once)')
            ]
        ];

        return Inertia::render('Admin/Cron/Index', compact('segments', 'buttons', 'jobs'));
    }
}
