@extends('layouts.app')

@section('title', __('group.edit'))

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @if (request('action') == 'delete' && $group)
        @can('delete', $group)
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">{{ __('group.delete') }}</h3></div>
                <div class="panel-body">
                    <label class="control-label">{{ __('group.name') }}</label>
                    <p>{{ $group->name }}</p>
                    <label class="control-label">{{ __('group.members_count') }}</label>
                    <p>{{ $group->members()->count() }}</p>
                    <label class="control-label">{{ __('group.currency') }}</label>
                    <p>{{ $group->currency }}</p>
                    <label class="control-label">{{ __('group.status') }}</label>
                    <p>{{ $group->status }}</p>
                    <label class="control-label">{{ __('group.description') }}</label>
                    <p>{{ $group->description }}</p>
                    {!! $errors->first('group_id', '<span class="form-error small">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="panel-body">{{ __('app.delete_confirm') }}</div>
                <div class="panel-footer">
                    {!! FormField::delete(
                        ['route' => ['groups.destroy', $group]],
                        __('app.delete_confirm_button'),
                        ['class'=>'btn btn-danger'],
                        [
                            'group_id' => $group->id,
                            'page' => request('page'),
                            'q' => request('q'),
                        ]
                    ) !!}
                    {{ link_to_route('groups.edit', __('app.cancel'), [$group], ['class' => 'btn btn-default']) }}
                </div>
            </div>
        @endcan
        @else
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">{{ __('group.edit') }}</h3></div>
            {!! Form::model($group, ['route' => ['groups.update', $group],'method' => 'patch']) !!}
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
                        {!! FormField::text('currency', ['required' => true, 'label' => __('group.currency')]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! FormField::price('payment_amount', [
                            'required' => true,
                            'label' => __('group.payment_amount')
                        ]) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">{!! FormField::text('start_date', ['label' => __('group.start_date')]) !!}</div>
                    <div class="col-md-6">{!! FormField::text('end_date', ['label' => __('group.end_date')]) !!}</div>
                </div>
                {!! FormField::textarea('description', ['label' => __('group.description')]) !!}
            </div>
            <div class="panel-footer">
                {!! Form::submit(__('group.update'), ['class' => 'btn btn-success']) !!}
                {{ link_to_route('groups.show', __('app.cancel'), [$group], ['class' => 'btn btn-default']) }}
                @can('delete', $group)
                    {{ link_to_route('groups.edit', __('app.delete'), [$group, 'action' => 'delete'], ['class' => 'btn btn-danger pull-right', 'id' => 'del-group-'.$group->id]) }}
                @endcan
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif
@endsection

@section('styles')
    {{ Html::style(url('css/plugins/jquery.datetimepicker.css')) }}
@endsection

@push('scripts')
    {{ Html::script(url('js/plugins/jquery.datetimepicker.js')) }}
<script>
(function() {
    $('#start_date,#end_date').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endpush
