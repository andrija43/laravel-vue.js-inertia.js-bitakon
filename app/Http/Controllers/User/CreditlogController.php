<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Creditlog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Auth;
class CreditlogController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $creditlogs = Creditlog::query()
            ->with(['user:id,name,created_at', 'gateway'])
            ->latest()
            ->where('user_id',Auth::id())
            ->paginate(10);
        return Inertia::render('Frontend/Dashboard/Credit/Index', [
            'creditlogs' => $creditlogs,
        ]);
    }
}
