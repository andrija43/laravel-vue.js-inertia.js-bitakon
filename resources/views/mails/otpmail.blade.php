@component('mail::message')
<h1 > {{ env('APP_NAME') }}</h1>

<h1>{{ __('Hi') }},</h1>
<p>{{ __('If you did try to payout, copy and paste this verification code') }}:</p>
<h3 >{{ $otp }}</h3>

<p>{{ __('Thanks') }},</p>
<p>{{ env('APP_NAME') }}.</p>
@endcomponent