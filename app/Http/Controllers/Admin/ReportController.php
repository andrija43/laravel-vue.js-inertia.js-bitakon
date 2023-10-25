<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $segments = request()->segments();
        $buttons = [];
        $reports = Report::query()
            ->with(['user:id,name,created_at', 'prompt:id,title,preview,meta,slug'])
            ->latest()
            ->paginate(10);
        $totalReports = Report::query()->count();
        $last7DayReports = Report::query()->whereBetween('created_at', [now()->subDays(7), now()])->count();
        $last30DayReports = Report::query()->whereBetween('created_at', [now()->subDays(30), now()])->count();

        return Inertia::render('Admin/Report/Index', [
            'reports' => $reports,
            'buttons' => $buttons,
            'segments' => $segments,
            'totalReports' => $totalReports,
            'last7DayReports' => $last7DayReports,
            'last30DayReports' => $last30DayReports,
        ]);
    }
}
