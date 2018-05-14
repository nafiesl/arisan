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
