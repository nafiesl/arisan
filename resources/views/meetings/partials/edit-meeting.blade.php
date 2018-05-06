<div id="meetingModal" class="modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                {{ link_to_route('meetings.show', '&times;', $meeting, ['class' => 'close']) }}
                <h4 class="modal-title">{{ __('meeting.edit', ['number' => $meeting->number]) }}</h4>
            </div>
            {{ Form::model($meeting, ['route' => ['meetings.update', $meeting], 'method' => 'patch']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">{!! FormField::textDisplay('number', $meeting->number, ['label' => __('meeting.number')]) !!}</div>
                    <div class="col-md-6">{!! FormField::text('date', ['required' => true, 'label' => __('meeting.date'), 'class' => 'date-select']) !!}</div>
                </div>
                {!! FormField::text('place', ['label' => __('meeting.place'), 'placeholder' => 'Contoh: Inter Cafe']) !!}
                {!! FormField::textarea('notes', ['label' => __('meeting.notes')]) !!}
            </div>
            <div class="modal-footer">
                {{ Form::submit(__('meeting.update', ['number' => $meeting->number]), ['class' => 'btn btn-info']) }}
                {{ link_to_route('meetings.show', __('app.cancel'), $meeting, ['class' => 'btn btn-default']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
