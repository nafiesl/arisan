@extends('layouts.app')

@section('title', __('meeting.detail'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        {{ link_to_route(
            'meetings.show',
            __('meeting.set_winner'),
            [$meeting, 'action' => 'set-winner'],
            ['id' => 'set-winner', 'class' => 'btn btn-success']
        ) }}
        {{ link_to_route(
            'meetings.show',
            __('meeting.edit', ['number' => $meeting->number]),
            [$meeting, 'action' => 'edit-meeting'],
            ['id' => 'edit-meeting-'.$meeting->number, 'class' => 'btn btn-warning']
        ) }}
        {{ link_to_route('groups.meetings.index', __('meeting.back_to_index'), [$meeting->group], ['class' => 'btn btn-default']) }}
    </div>
    {{ __('meeting.number') }} {{ $meeting->number }}
    <small>{{ $meeting->group->name }}</small>
</h1>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('meeting.detail') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><td class="col-md-4">{{ __('group.group') }}</td><td>{{ $meeting->group->nameLink() }}</td></tr>
                    <tr><td>{{ __('meeting.number') }}</td><td>{{ $meeting->number }}</td></tr>
                    <tr><td>{{ __('meeting.date') }}</td><td>{{ $meeting->date }}</td></tr>
                    <tr><td>{{ __('meeting.place') }}</td><td>{{ $meeting->place }}</td></tr>
                    <tr><td>{{ __('meeting.creator') }}</td><td>{{ $meeting->creator->name }}</td></tr>
                    <tr><td>{{ __('meeting.notes') }}</td><td>{{ $meeting->notes }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('meeting.payments') }}</h3></div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th style="width: 5%" class="text-center">{{ __('app.table_no') }}</th>
                        <th style="width: 25%">{{ __('user.name') }}</th>
                        <th style="width: 10%" class="text-center">{{ __('app.status') }}</th>
                        <th style="width: 17%" class="text-center">{{ __('payment.amount') }}</th>
                        <th style="width: 13%" class="text-center">{{ __('payment.date') }}</th>
                        <th style="width: 20%">{{ __('payment.to') }}</th>
                        <th style="width: 10%" class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $key => $member)
                    @php
                        $membershipId = $member->pivot->id;
                        $payment = $payments->filter(function ($payment) use ($membershipId, $meeting) {
                            return $payment->membership_id == $membershipId
                            && $payment->meeting_id == $meeting->id;
                        })->first();
                    @endphp
                    {{ Form::open(['route' => ['meetings.payment-entry', $meeting]]) }}
                    {{ Form::hidden('membership_id', $membershipId) }}
                    <tr>
                        <td class="text-center">{{ 1 + $key }}</td>
                        <td>{{ $member->name }}</td>
                        <td class="text-center">
                            @if ($meeting->winner_id == $membershipId)
                                <span class="label label-primary">{{ __('meeting.winner') }}</span>
                            @elseif ($payment)
                                <span class="label label-success">{{ __('payment.done') }}</span>
                            @else
                                <span class="label label-default">{{ __('payment.not_yet') }}</span>
                            @endif
                        </td>
                        <td class="text-right">
                            {!! FormField::price(
                                'amount',
                                ['value' => optional($payment)->amount, 'label' => false, 'required' => true]
                            ) !!}
                        </td>
                        <td class="text-center">
                            {!! FormField::text(
                                'date',
                                [
                                    'value' => $payment ? $payment->date : $meeting->date,
                                    'label' => false,
                                    'required' => true,
                                    'class' => 'date-select',
                                ]
                            ) !!}
                        </td>
                        <td>
                            {!! FormField::select(
                                'payment_receiver_id',
                                $members->pluck('name', 'id'),
                                [
                                    'value' => optional($payment)->payment_receiver_id,
                                    'label' => false,
                                    'required' => true
                                ]
                            ) !!}
                        </td>
                        <td class="text-center">
                            {{ Form::submit(
                                __('app.update'),
                                [
                                    'id' => 'payment-entry-'.$membershipId,
                                    'class' => 'btn btn-success btn-xs',
                                    'title' => __('payment.update'),
                                ]
                            ) }}
                        </td>
                    </tr>
                    {{ Form::close() }}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@includeWhen(request('action') == 'edit-meeting', 'meetings.partials.edit-meeting')

@if (request('action') == 'set-winner')
<div id="meetingModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                {{ link_to_route('meetings.show', '&times;', $meeting, ['class' => 'close']) }}
                <h4 class="modal-title">{{ __('meeting.set_winner') }}</h4>
            </div>
            {{ Form::model($meeting, ['route' => ['meetings.set-winner', $meeting]]) }}
            <div class="modal-body">
                {!! FormField::select('winner_id', $winnerCadidateList, ['required' => true, 'label' => __('meeting.winner')]) !!}
            </div>
            <div class="modal-footer">
                {{ Form::submit(__('meeting.set_winner'), ['class' => 'btn btn-info']) }}
                {{ link_to_route('meetings.show', __('app.cancel'), $meeting, ['class' => 'btn btn-default']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endif
@endsection

@section('styles')
    {{ Html::style(url('css/plugins/jquery.datetimepicker.css')) }}
    <style>
        .table .input-group-addon { padding: 5px 8px; }
    </style>
@endsection

@push('scripts')
    {{ Html::script(url('js/plugins/jquery.datetimepicker.js')) }}
<script>
(function() {
    $('#meetingModal').modal({
        show: true,
        backdrop: 'static',
    });
    $('.date-select').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endpush
