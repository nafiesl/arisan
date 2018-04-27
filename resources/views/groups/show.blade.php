@extends('layouts.app')

@section('title', __('group.detail'))

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('group.detail') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><td>{{ __('group.name') }}</td><td>{{ $group->name }}</td></tr>
                    <tr><td>{{ __('group.members') }}</td><td>{{ $group->members->count() }}</td></tr>
                    <tr><td>{{ __('group.description') }}</td><td>{{ $group->description }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                @can('update', $group)
                    {{ link_to_route('groups.edit', __('group.edit'), [$group], ['class' => 'btn btn-warning', 'id' => 'edit-group-'.$group->id]) }}
                @endcan
                {{ link_to_route('groups.index', __('group.back_to_index'), [], ['class' => 'btn btn-default']) }}
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('group.members') }}</h3></div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>{{ __('app.table_no') }}</th>
                        <th>{{ __('user.name') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($group->members as $key => $member)
                    <tr>
                        <td>{{ 1 + $key }}</td>
                        <td>{{ $member->name }}</td>
                        <td class="text-center">
                            {!! FormField::delete([
                                'route' => ['groups.members.destroy', $group, $member],
                                'onsubmit' => __('group.remove_member_confirm'),
                                'class' => '',
                            ], __('group.remove_member'), [
                                'class' => 'btn btn-danger btn-xs',
                                // 'style' => 'padding:0px 7px;border-radius:50%',
                                'id' => 'remove-member-' . $member->pivot->id,
                                'title' => __('group.remove_member'),
                            ], [
                                'group_member_id' => $member->pivot->id
                            ]) !!}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3">{{ __('group.empty_member') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="panel-body">
                {{ Form::open(['route' => ['groups.members.store', $group]]) }}
                <div class="input-group">
                    {{ Form::text('email', null, ['required' => true, 'class' => 'form-control', 'id' => 'email', 'placeholder' => __('group.add_member_text')]) }}
                    <span class="input-group-btn">
                        {{ Form::submit(__('group.add_member'), ['class' => 'btn btn-info']) }}
                    </span>
                </div><!-- /input-group -->
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
