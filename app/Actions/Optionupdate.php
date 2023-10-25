<?php

namespace App\Actions;

use Illuminate\Http\Request;
use App\Models\Option;
use Str;
use Artisan;
use App\Traits\Uploader;
use Cache;

class Optionupdate
{
    use Uploader;


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function primaryDataUpdate(Request $request)
    {

        $primary_data = Option::where('key', 'primary_data')->first();
        $optionData = json_decode($primary_data->value);

        if (request()->hasFile('primary_data.logo')) {
            $newLogo = $this->saveFile(request(), 'primary_data.logo');
            $this->removeFile($optionData->logo);
            $optionData->logo = $newLogo;
        }

        if (request()->hasFile('primary_data.favicon')) {
            $favicon = $this->saveFile(request(), 'primary_data.favicon');
            $this->removeFile($optionData->favicon);
            $optionData->favicon = $favicon;
        }

        if (request()->hasFile('primary_data.logo_dark')) {
            $logo_dark = $this->saveFile(request(), 'primary_data.logo_dark');
            $this->removeFile($optionData->logo_dark ?? null);
            $optionData->logo_dark = $logo_dark;
        }

        $optionData->contact_email = $request->primary_data['contact_email'];
        $optionData->contact_phone = $request->primary_data['contact_phone'];
        $optionData->address       = $request->primary_data['address'];
        $optionData->marquee       = $request->primary_data['marquee'];
        $optionData->footer_description = $request->primary_data['footer_description'];
        $optionData->socials       = $request->primary_data['socials'];

        $primary_data->value = json_encode($optionData);
        $primary_data->save();
    }

    public function themeUpdate(Request $request)
    {
        $theme = Option::where('key', 'theme_path')->first();

        if (empty($theme)) {
            $theme = new Option;
            $theme->key = 'theme_path';
        }
        $theme->value = $request->path;
        $theme->save();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function headerFooterUpdate(Request $request)
    {
        $locale = current_locale();

        $header_footer = Option::where('key', 'header_footer')->where('lang', $locale)->first();
        if (empty($header_footer)) {
            $request->validate([
                'header_footer.certificate_image' => 'required|image|max:1024',
                'header_footer.certificate_image_dark' => 'required|image|max:1024',
            ]);

            $header_footer = new Option;
            $header_footer->key = 'header_footer';
            $header_footer->lang = $locale;

            $newData['header'] = $request->header_footer['header'];
            $newData['footer'] = $request->header_footer['footer'];



            $certificate_image = $this->saveFile($request, 'header_footer.certificate_image');
            $newData['certificate_image'] = $certificate_image;

            $certificate_image_dark = $this->saveFile($request, 'header_footer.certificate_image_dark');
            $newData['certificate_image_dark'] = $certificate_image_dark;
        } else {

            $request->validate([
                'header_footer.certificate_image' => 'nullable|image|max:1024',
                'header_footer.certificate_image_dark' => 'nullable|image|max:1024',
            ]);

            $optionData = json_decode($header_footer->value ?? '');

            $newData['header'] = $request->header_footer['header'];
            $newData['footer'] = $request->header_footer['footer'];


            if ($request->hasFile('header_footer.certificate_image')) {
                $certificate_image = $this->saveFile($request, 'header_footer.certificate_image');
                $this->removeFile($optionData->certificate_image ?? null);
                $newData['certificate_image'] = $certificate_image;
            } else {
                $newData['certificate_image'] = $optionData->certificate_image ?? null;
            }

            if ($request->hasFile('header_footer.certificate_image_dark')) {
                $certificate_image_dark = $this->saveFile($request, 'header_footer.certificate_image_dark');
                $newData['certificate_image_dark'] = $certificate_image_dark;
            } else {
                $newData['certificate_image_dark'] = $optionData->certificate_image_dark ?? null;
            }
        }

        $header_footer->value = json_encode($newData);
        $header_footer->save();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contactPageUpdate(Request $request)
    {


        $contact = Option::where('key', 'contact-page')->first();
        if (empty($contact)) {
            $contact = new Option;
            $contact->key = 'contact-page';
        }

        $contact->value = json_encode($request->contact_page);
        $contact->save();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function homePageUpdate(Request $request)
    {
        $locale = current_locale();

        $option = Option::where('key', 'home-page')->where('lang', $locale)->first();
        if (empty($option)) {
            $request->validate([
                'home.cta_logo'           => 'required|image|max:1024',
                'home.cta_thumbnail'      => 'required|image|max:1024',
                'home.about.qr_code'  => 'nullable|image|max:1024',
            ]);

            $option = new Option;
            $option->key = 'home-page';
            $option->lang = $locale;

            $optionData = $request->home;
            if ($request->hasFile('home.about.qr_code')) {
                $qr_code = $this->saveFile($request, 'home.about.qr_code');
                $optionData['qr_code'] = $qr_code;
            }

            if ($request->hasFile('home.cta_logo')) {
                $cta_logo = $this->saveFile($request, 'home.cta_logo');
                $optionData['cta_logo'] = $cta_logo;
            }

            if ($request->hasFile('home.cta_thumbnail')) {
                $cta_thumbnail = $this->saveFile($request, 'home.cta_thumbnail');
                $optionData['cta_thumbnail'] = $cta_thumbnail;
            }

            $data = json_encode($optionData);
            $option->value = $data;
            $option->save();
        } else {

            $optionData = $request->home;
            $oldData = json_decode($option->value ?? '');

            if ($request->hasFile('home.about.qr_code')) {
                $qr_code = $this->saveFile($request, 'home.about.qr_code');
                $optionData['qr_code'] = $qr_code;
            } else {
                $optionData['qr_code'] = $oldData->qr_code ?? null;
            }
            if ($request->hasFile('home.cta_logo')) {
                $cta_logo = $this->saveFile($request, 'home.cta_logo');
                $optionData['cta_logo'] = $cta_logo;
            } else {
                $optionData['cta_logo'] = $oldData->cta_logo ?? null;
            }

            if ($request->hasFile('home.cta_thumbnail')) {
                $cta_thumbnail = $this->saveFile($request, 'home.cta_thumbnail');
                $optionData['cta_thumbnail'] = $cta_thumbnail;
            } else {
                $optionData['cta_thumbnail'] = $oldData->cta_thumbnail ?? null;
            }

            $data = json_encode($optionData);
            $option->value = $data;
            $option->save();
        }
    }
}
