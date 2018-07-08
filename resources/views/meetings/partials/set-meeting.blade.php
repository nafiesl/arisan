<div id="meetingModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                {{ link_to_route('groups.meetings.index', '&times;', $group, ['class' => 'close']) }}
                <h4 class="modal-title">{{ __('meeting.create', ['number' => $meetingNumber]) }}</h4>
            </div>
            {{ Form::open(['route' => ['groups.meetings.store', $group]]) }}
            {{ Form::hidden('number', $meetingNumber) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">{!! FormField::textDisplay('number', $meetingNumber, ['label' => __('meeting.number')]) !!}</div>
                    <div class="col-md-6">{!! FormField::text('date', ['required' => true, 'label' => __('meeting.date')]) !!}</div>
                </div>
                {!! FormField::text('place', ['label' => __('meeting.place'), 'placeholder' => 'Contoh: Inter Cafe']) !!}
                {!! FormField::textarea('notes', ['label' => __('meeting.notes')]) !!}
            </div>
            <div class="modal-footer">
                {{ Form::submit(__('meeting.create', ['number' => $meetingNumber]), ['class' => 'btn btn-info']) }}
                {{ link_to_route('groups.meetings.index', __('app.cancel'), $group, ['class' => 'btn btn-default']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
