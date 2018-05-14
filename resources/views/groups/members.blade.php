@extends('layouts.group')

@section('subtitle', __('group.members'))

@section('content-group')
<div class="panel panel-default">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th class="text-center">{{ __('app.table_no') }}</th>
                <th>{{ __('user.name') }}</th>
                <th>{{ __('meeting.win') }}</th>
                <th class="text-center">{{ __('app.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($group->members as $key => $member)
            @php
                $membershipId = $member->pivot->id;
                $winningMeeting = $meetings->where('winner_id', $membershipId)->first();
            @endphp
            <tr>
                <td class="text-center">{{ 1 + $key }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $winningMeeting ? __('meeting.meeting').' '.$winningMeeting->number : '' }}</td>
                <td class="text-center">
                    @unless ($winningMeeting)
                    {!! FormField::delete([
                        'route' => ['groups.members.destroy', $group, $member],
                        'onsubmit' => __('group.remove_member_confirm', ['name' => $member->name]),
                        'class' => '',
                    ], __('group.remove_member'), [
                        'class' => 'btn btn-danger btn-xs',
                        'id' => 'remove-member-' . $member->pivot->id,
                        'title' => __('group.remove_member'),
                    ], [
                        'group_member_id' => $member->pivot->id
                    ]) !!}
                    @endunless
                </td>
            </tr>
            @empty
            <tr><td colspan="3">{{ __('group.empty_member') }}</td></tr>
            @endforelse
        </tbody>
    </table>
    @if (!$group->isFull())
    <div class="panel-body">
        {{ Form::open(['route' => ['groups.members.store', $group]]) }}
        <div class="input-group">
            {{ Form::email('email', null, ['required' => true, 'class' => 'form-control', 'id' => 'email', 'placeholder' => __('group.add_member_text')]) }}
            <span class="input-group-btn">
                {{ Form::submit(__('group.add_member'), ['class' => 'btn btn-info']) }}
            </span>
        </div><!-- /input-group -->
        {{ Form::close() }}
    </div>
    @endif
</div>
@endsection
