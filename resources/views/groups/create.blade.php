@extends('layouts.app')

@section('title', trans('group.create'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ trans('group.create') }}</h3></div>
            {!! Form::open(['route' => 'groups.store']) !!}
            <div class="panel-body">
                {!! FormField::text('name', ['required' => true, 'label' => trans('group.name')]) !!}
                {!! FormField::textarea('description', ['label' => trans('group.description')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(trans('group.create'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('groups.index', trans('app.cancel'), [], ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
