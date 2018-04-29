@php
    $meeting = App\Meeting::where(['group_id' => $group->id, 'number' => request('number')])->firstOrFail();
@endphp

@if ($meeting)
<div id="meetingModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                {{ link_to_route('groups.meetings.index', '&times;', $group, ['class' => 'close']) }}
                <h4 class="modal-title">{{ __('meeting.edit', ['number' => $meeting->number]) }}</h4>
            </div>
            {{ Form::model($meeting, ['route' => ['groups.meetings.update', $group, $meeting], 'method' => 'patch']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">{!! FormField::textDisplay('number', $meeting->number, ['label' => __('meeting.number')]) !!}</div>
                    <div class="col-md-6">{!! FormField::text('date', ['required' => true, 'label' => __('meeting.date')]) !!}</div>
                </div>
                {!! FormField::text('place', ['label' => __('meeting.place'), 'placeholder' => 'Contoh: Inter Cafe']) !!}
                {!! FormField::textarea('notes', ['label' => __('meeting.notes')]) !!}
            </div>
            <div class="modal-footer">
                {{ Form::submit(__('meeting.update', ['number' => $meeting->number]), ['class' => 'btn btn-info']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endif
