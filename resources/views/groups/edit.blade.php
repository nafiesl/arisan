@extends('layouts.app')

@section('title', trans('group.edit'))

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @if (request('action') == 'delete' && $group)
        @can('delete', $group)
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">{{ trans('group.delete') }}</h3></div>
                <div class="panel-body">
                    <label class="control-label">{{ trans('group.name') }}</label>
                    <p>{{ $group->name }}</p>
                    <label class="control-label">{{ trans('group.description') }}</label>
                    <p>{{ $group->description }}</p>
                    {!! $errors->first('group_id', '<span class="form-error small">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="panel-body">{{ trans('app.delete_confirm') }}</div>
                <div class="panel-footer">
                    {!! FormField::delete(
                        ['route' => ['groups.destroy', $group]],
                        trans('app.delete_confirm_button'),
                        ['class'=>'btn btn-danger'],
                        [
                            'group_id' => $group->id,
                            'page' => request('page'),
                            'q' => request('q'),
                        ]
                    ) !!}
                    {{ link_to_route('groups.edit', trans('app.cancel'), [$group], ['class' => 'btn btn-default']) }}
                </div>
            </div>
        @endcan
        @else
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('group.edit') }}</h3></div>
            {!! Form::model($group, ['route' => ['groups.update', $group],'method' => 'patch']) !!}
            <div class="panel-body">
                {!! FormField::text('name', ['required' => true, 'label' => trans('group.name')]) !!}
                {!! FormField::textarea('description', ['label' => trans('group.description')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('group.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('groups.show', trans('app.cancel'), [$group], ['class' => 'btn btn-default']) }}
                @can('delete', $group)
                    {{ link_to_route('groups.edit', trans('app.delete'), [$group, 'action' => 'delete'], ['class' => 'btn btn-danger pull-right', 'id' => 'del-group-'.$group->id]) }}
                @endcan
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif
@endsection
