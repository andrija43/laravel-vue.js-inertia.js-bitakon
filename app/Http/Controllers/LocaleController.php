<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function update($locale)
    {
        session()->put('locale', $locale);
        app()->setLocale($locale);
        return inertia()->location(url()->previous());
    }
}
