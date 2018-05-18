@extends('layouts.group')

@section('subtitle', trans('group.outstanding_payments'))

@section('content-group')
@foreach($meetings as $key => $meeting)
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">
                <span class="pull-right">
                    {{ __('meeting.winner') }} : {{ optional($meeting->winner)->user->name }}
                </span>
                {{ __('meeting.meeting') }} {{ $meeting->number }}
            </h3>
        </div>
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th class="text-center">{{ __('app.table_no') }}</th>
                    <th>{{ __('group.members') }}</th>
                    <th class="text-right">{{ __('payment.unpaid') }}</th>
                    <th class="text-center">{{ __('app.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 0;
                    $outstandingPaymentAmount = 0;
                @endphp
                @foreach ($members as $key => $member)
                @php
                    $membershipId = $member->pivot->id;
                    $payment = $meeting->payments->filter(function ($payment) use ($membershipId, $meeting) {
                        return $payment->membership_id == $membershipId
                        && $payment->meeting_id == $meeting->id;
                    })->first();
                @endphp
                @unless ($payment)
                <tr>
                    <td class="text-center">{{ ++$no }}</td>
                    <td>{{ $member->name }}</td>
                    <td class="text-right">
                        {{ formatNo($group->payment_amount) }}
                    </td>
                    <td class="text-center">
                        {{ link_to_route('meetings.show', __('payment.pay'), $meeting, ['class' => 'btn btn-default btn-xs']) }}
                    </td>
                </tr>
                @php
                    $outstandingPaymentAmount += $group->payment_amount;
                @endphp
                @endunless
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-right">{{ __('app.total') }} {{ __('payment.unpaid') }}</th>
                    <th class="text-right">{{ $group->currency }} {{ formatNo($outstandingPaymentAmount) }}</th>
                    <th>&nbsp;</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endforeach
@endsection
