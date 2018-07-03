@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('nav_menu.your_groups') }}</h3>
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('app.table_no') }}</th>
                        <th>{{ trans('group.name') }}</th>
                        <th class="text-center">{{ trans('group.members') }}</th>
                        <th class="text-right">{{ trans('group.payment_amount') }}</th>
                        <th class="text-center">{{ trans('app.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $key => $group)
                    <tr>
                        <td class="text-center">{{ 1 + $key }}</td>
                        <td>{{ $group->nameLink() }}</td>
                        <td class="text-center">{{ $group->members_count }}</td>
                        <td class="text-right">{{ $group->currency }} {{ formatNo($group->payment_amount) }}</td>
                        <td class="text-center">{{ $group->status }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center bg-warning">{{ __('group.empty') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ __('nav_menu.your_outstanding_payments') }}</h3>
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('app.table_no') }}</th>
                        <th>{{ trans('group.name') }}</th>
                        <th class="text-center">{{ trans('meeting.number') }}</th>
                        <th class="text-right">{{ trans('payment.payment') }}</th>
                        <th class="text-center">{{ trans('app.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($outstandingPayments->isEmpty())
                        <tr><td colspan="5" class="text-center bg-warning">{{ __('user.no_outstanding_payment') }}</td></tr>
                    @endif
                    @foreach($outstandingPayments->groupBy('group_id') as $groupId => $groupedMeetings)
                        @php
                            $no = 0;
                            $outstandingPaymentsTotal = 0;
                        @endphp

                        @foreach($groupedMeetings as $key => $meeting)

                            @php
                                $payment = $meeting->payments->where('membership_id', $membershipIds[$meeting->group_id])->first();
                            @endphp

                            @unless ($payment)
                                <tr>
                                    <td class="text-center">{{ ++$no }}</td>
                                    <td>{{ $meeting->group->nameLink() }}</td>
                                    <td class="text-center">{{ link_to_route('meetings.show', $meeting->number, $meeting) }}</td>
                                    <td class="text-right">
                                        {{ formatNo($paymentAmount = $meeting->group->payment_amount) }}
                                    </td>
                                    <td class="text-center">{{ __('payment.not_yet') }}</td>
                                </tr>
                                @php $outstandingPaymentsTotal += $paymentAmount; @endphp
                            @endif
                        @endforeach
                        <tr>
                            <th colspan="3">{{ __('app.total') }}</th>
                            <th class="text-right">{{ formatNo($outstandingPaymentsTotal) }}</th>
                            <th>&nbsp;</th>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
