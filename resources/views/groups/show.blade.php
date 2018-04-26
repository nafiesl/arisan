@extends('layouts.app')

@section('title', trans('group.detail'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('group.detail') }}</h3></div>
            <table class="table table-condensed">
                <tbody>
                    <tr><td>{{ trans('group.name') }}</td><td>{{ $group->name }}</td></tr>
                    <tr><td>{{ trans('group.description') }}</td><td>{{ $group->description }}</td></tr>
                </tbody>
            </table>
            <div class="panel-footer">
                @can('update', $group)
                    {{ link_to_route('groups.edit', trans('group.edit'), [$group], ['class' => 'btn btn-warning', 'id' => 'edit-group-'.$group->id]) }}
                @endcan
                {{ link_to_route('groups.index', trans('group.back_to_index'), [], ['class' => 'btn btn-default']) }}
            </div>
        </div>
    </div>
</div>
@endsection
