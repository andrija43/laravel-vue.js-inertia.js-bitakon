<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use App\Traits\Uploader;
use App\Actions\Optionupdate;
use Cache;
use Inertia\Inertia;

class SettingsController extends Controller
{
    use Uploader;


    public function __construct()
    {
        $this->middleware('permission:page-settings');
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
        $locale = current_locale();
        $primary_data = get_option('primary_data', true);

        $theme_path = get_option('theme_path');
        $theme_path = empty($theme_path) ? 'Home' : $theme_path;
        $headerFooter = Option::where('key', 'header_footer')->where('lang', $locale)->first();
        $headerFooter = json_decode($headerFooter->value ?? '');
        $contact_page = get_option('contact-page', true);
        $home = get_option('home-page', true, true);

        $features_area =  $home->brand->status ?? 'active';
        $brand_area = $home->brand->status ?? 'active';
        $account_area = $home->account_area->status ?? 'active';

        return Inertia::render('Admin/PageSetting/Index', [
            'primary_data' => $primary_data,
            'headerFooter' => $headerFooter,
            'contact_page' => $contact_page,
            'home' => $home,
            'features_area' => $features_area,
            'brand_area' => $brand_area,
            'account_area' => $account_area,
            'theme_path' => $theme_path,
            'buttons' => $buttons,
            'segments' => $segments,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Optionupdate $optionupdate)
    {
        if ($id == 'primary_data') {

            $request->validate([
                'logo' => 'nullable|image|max:1024',
                'logo_dark' => 'nullable|image|max:1024',
                'favicon' => 'nullable|image|max:500',
            ]);


            $optionupdate->primaryDataUpdate($request);
            Cache::flush();

            return back();
        } elseif ($id == 'header_footer') {

            $optionupdate->headerFooterUpdate($request);
            Cache::flush();

            return back();
        } elseif ($id == 'contact-page') {

            $optionupdate->contactPageUpdate($request);
            Cache::flush();

            return back();
        } elseif ($id == 'home-page') {
            $optionupdate->homePageUpdate($request);
            Cache::flush();
            return back();
        } elseif ($id == 'theme') {
            $optionupdate->themeUpdate($request);
            Cache::flush();
            return back();
        }
    }
}
