<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Mail;
use Session;
use App\Traits\Seo;
use Inertia\Inertia;

class ContactController extends Controller
{
    use Seo;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seo = get_option('seo_contact', true);
        $meta['title'] = $seo->site_name ?? '';
        $meta['site_name'] = $seo->site_name ?? '';
        $meta['description'] = $seo->matadescription ?? '';
        $meta['tags'] = $seo->matatag ?? '';
        $meta['preview'] = asset($seo->preview ?? '');

        $contact_page = get_option('contact-page', true);

        config()->set('seotools.metaDescription',$meta['description']);
        config()->set('seotools.keyWords',$meta['tags']);
        config()->set('seotools.site_name',$meta['title']);
        config()->set('seotools.current_url', url()->current());
        config()->set('seotools.metaImage',$meta['preview']);

        return Inertia::render('Frontend/Contact/Index', [
            'contact_page' => $contact_page,
            'seo' => $meta,
        ]);
    }

    /**
     * submit mail to the site admin
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMail(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:20'],
            'email'    => 'required|email:rfc,dns|max:40',
            'phone'    => 'required|max:11|min:11',
            'subject'    => 'required|max:100',
            'message'    => 'required|max:500',
        ]);

        try {

            $data['name']    = $request->name;
            $data['email']   = $request->email;
            $data['phone']   = $request->phone;
            $data['subject'] = $request->subject;
            $data['message'] = $request->message;

            env('QUEUE_MAIL') == true ? Mail::to(env('MAIL_TO'))->queue(new ContactMail($data)) : Mail::to(env('MAIL_TO'))->send(new ContactMail($data));

            return back();
        } catch (Exception $e) {
            Session::flash('error', __('Something wrong'));

            return back();
        }
    }
}