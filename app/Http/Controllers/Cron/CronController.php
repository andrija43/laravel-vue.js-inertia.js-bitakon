<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
class CronController extends Controller
{
    public function executeJob() {
        ini_set('max_execution_time', 0);
        
        Artisan::call('queue:work');

        return "job executed successfully";
    }
}
