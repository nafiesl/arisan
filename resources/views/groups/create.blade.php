@extends('layouts.app')

@section('title', __('group.create'))

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('group.create') }}</h3></div>
            {!! Form::open(['route' => 'groups.store']) !!}
            <div class="panel-body">
                {!! FormField::text('name', ['required' => true, 'label' => __('group.name')]) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! FormField::text('capacity', [
                            'min' => 0,
                            'type' => 'number',
                            'required' => true,
                            'label' => __('group.capacity'),
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::text('currency', [
                            'required' => true,
                            'value' => old('currency', 'IDR'),
                            'label' => __('group.currency')
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::price('payment_amount', [
                            'required' => true,
                            'label' => __('group.payment_amount')
                        ]) !!}
                    </div>
                </div>
                {!! FormField::textarea('description', ['label' => __('group.description')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(__('group.create'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('groups.index', __('app.cancel'), [], ['class' => 'btn btn-default']) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
