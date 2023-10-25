@component('mail::message')
<h1 >@lang('Payout request from') {{ env('APP_NAME') }}</h1>

<table >
    <thead >
        <tr>
            <th>{{ __('User name') }}</th>
            <td>{{ $payout->user->name ?? '' }}</td>
        </tr>
        <tr>
            <th>{{ __('User email') }}</th>
            <td>{{ $payout->user->email ?? '' }}</td>
        </tr>
        <tr>
            <th>{{ __('Amount') }}</th>
            <td>{{ $payout->amount }}</td>
        </tr>
        <tr>
            <th>{{ __('Payout method') }}</th>
            <td>{{ $payout->method->name ?? '' }}</td>
        </tr>
        <tr>
            <th>{{ __('Status') }}</th>
            <td style="color: {{ $payout->status == 'rejected' ? 'red':'green' }}">{{ $payout->status }}</td>
        </tr>
        <tr>
            <th>{{ __('Charge') }}</th>
            <td>{{ $payout->charge }}</td>
        </tr>
    </tbody>
</table>
@endcomponent