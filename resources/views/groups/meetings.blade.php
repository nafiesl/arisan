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
                                'groups.meetings.index',
                                __('app.edit'),
                                [$group, 'number' => $meetingNumber, 'action' => 'edit-meeting'],
                                ['id' => 'edit-meeting-'.$meetingNumber]
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

@includeWhen(request('action') == 'set-meeting', 'meetings.partials.set-meeting')
@endsection

@push('scripts')
<script>
(function () {
    $('#meetingModal').modal({
        show: true,
        backdrop: 'static',
    });
})();
</script>
@endpush
