@extends('layouts.group')

@section('subtitle', trans('group.meetings'))

@section('content-group')
<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th class="text-center">{{ __('meeting.meeting') }}</th>
                <th class="text-center">{{ __('meeting.date') }}</th>
                <th>{{ __('meeting.place') }}</th>
                <th>{{ __('meeting.winner') }}</th>
                <th>{{ __('meeting.payment') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @for ($meetingNumber = 1; $meetingNumber <= $group->members()->count(); $meetingNumber++)
                @php
                    $meeting = $meetings->where('number', $meetingNumber)->first();
                @endphp
                @if ($meeting)
                    <tr>
                        <td class="text-center">{{ $meetingNumber }}</td>
                        <td class="text-center">{{ $meeting->date }}</td>
                        <td>{{ $meeting->place }}</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="text-center">
                            {{ link_to_route(
                                'meetings.show',
                                __('app.show'),
                                [$meeting],
                                ['id' => 'show-meeting-'.$meetingNumber]
                            ) }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="text-center">{{ $meetingNumber }}</td>
                        <td colspan="4" class="text-center">
                            {{ link_to_route(
                                'groups.meetings.index',
                                __('meeting.create', ['number' => $meetingNumber]),
                                [$group, 'number' => $meetingNumber, 'action' => 'set-meeting'],
                                ['id' => 'set-meeting-'.$meetingNumber]
                            ) }}
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                @endif
            @endfor
        </tbody>
    </table>
</div>

@if (request('action') == 'set-meeting' && $acceptableNumber)
    @include('meetings.partials.set-meeting', ['meetingNumber' => $acceptableNumber])
@endif

@endsection

@section('styles')
    {{ Html::style(url('css/plugins/jquery.datetimepicker.css')) }}
@endsection

@push('scripts')
    {{ Html::script(url('js/plugins/jquery.datetimepicker.js')) }}
<script>
(function() {
    $('#meetingModal').modal({
        show: true,
        backdrop: 'static',
    });
    $('#date').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endpush
