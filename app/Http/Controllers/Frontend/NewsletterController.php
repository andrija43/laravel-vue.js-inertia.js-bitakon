<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Newsletter\Facades\Newsletter;

class NewsletterController extends Controller
{

    /**
     * sent email to the mailchimp api
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        Newsletter::subscribe($request->email);

        return redirect()->back();
    }
}
