@extends('layouts.app')

@section('title', __('meeting.detail'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
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
</div>

@includeWhen(request('action') == 'edit-meeting', 'meetings.partials.edit-meeting')
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
