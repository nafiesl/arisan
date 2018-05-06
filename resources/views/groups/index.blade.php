@extends('layouts.app')

@section('title', trans('group.list'))

@section('content')
<h1 class="page-header">
    <div class="pull-right">
    @can('create', new App\Group)
        {{ link_to_route('groups.create', trans('group.create'), [], ['class' => 'btn btn-success']) }}
    @endcan
    </div>
    {{ trans('group.list') }}
    <small>{{ trans('app.total') }} : {{ $groups->total() }} {{ trans('group.group') }}</small>
</h1>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default table-responsive">
            <div class="panel-heading">
                {{ Form::open(['method' => 'get','class' => 'form-inline']) }}
                {!! FormField::text('q', ['value' => request('q'), 'label' => trans('group.search'), 'class' => 'input-sm']) !!}
                {{ Form::submit(trans('group.search'), ['class' => 'btn btn-sm']) }}
                {{ link_to_route('groups.index', trans('app.reset')) }}
                {{ Form::close() }}
            </div>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th class="text-center">{{ trans('app.table_no') }}</th>
                        <th>{{ trans('group.name') }}</th>
                        <th class="text-center">{{ trans('group.members') }}</th>
                        <th class="text-right">{{ trans('group.payment_amount') }}</th>
                        <th class="text-center">{{ trans('app.status') }}</th>
                        <th>{{ trans('group.creator') }}</th>
                        <th class="text-center">{{ trans('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups as $key => $group)
                    <tr>
                        <td class="text-center">{{ $groups->firstItem() + $key }}</td>
                        <td>{{ $group->nameLink() }}</td>
                        <td class="text-center">{{ $group->members_count }}</td>
                        <td class="text-right">{{ $group->currency }} {{ formatNo($group->payment_amount) }}</td>
                        <td class="text-center">{{ $group->status }}</td>
                        <td>{{ $group->creator->name }}</td>
                        <td class="text-center">
                        @can('view', $group)
                            {!! link_to_route(
                                'groups.show',
                                trans('app.show'),
                                [$group],
                                ['class' => 'btn btn-default btn-xs', 'id' => 'show-group-' . $group->id]
                            ) !!}
                        @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="panel-body">{{ $groups->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection
