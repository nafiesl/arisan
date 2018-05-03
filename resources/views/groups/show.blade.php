@extends('layouts.group')

@section('subtitle', __('group.detail'))

@section('action-buttons')
@can('update', $group)
    {{ link_to_route('groups.edit', __('group.edit'), [$group], ['class' => 'btn btn-warning', 'id' => 'edit-group-'.$group->id]) }}
@endcan
@endsection

@section('content-group')
<div class="panel panel-default table-responsive hidden-xs">
    <table class="table table-condensed table-bordered">
        <tr>
            <td class="col-xs-2 text-center">{{ trans('group.members_count') }}</td>
            <td class="col-xs-2 text-center">{{ trans('group.payment_amount') }}</td>
            <td class="col-xs-2 text-center">{{ trans('group.start_date') }}</td>
            <td class="col-xs-2 text-center">{{ trans('group.end_date') }}</td>
            <td class="col-xs-2 text-center">{{ trans('app.status') }}</td>
        </tr>
        <tr>
            <td class="text-center lead" style="border-top: none;">{{ $group->members->count() }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $group->currency }} {{ formatNo($group->payment_amount) }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $group->start_date }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $group->end_date }}</td>
            <td class="text-center lead" style="border-top: none;">{{ $group->status }}</td>
        </tr>
    </table>
</div>

<ul class="list-group visible-xs">
    <li class="list-group-item">{{ trans('group.members_count') }} <span class="pull-right">{{ $group->members->count() }}</span></li>
    <li class="list-group-item">{{ trans('group.payment_amount') }} <span class="pull-right">{{ $group->currency }} {{ formatNo($group->payment_amount) }}</span></li>
    <li class="list-group-item">{{ trans('group.start_date') }} <span class="pull-right">{{ $group->start_date }}</span></li>
    <li class="list-group-item">{{ trans('group.end_date') }} <span class="pull-right">{{ $group->end_date }}</span></li>
    <li class="list-group-item">{{ trans('app.status') }} <span class="pull-right">{{ $group->status }}</span></li>
</ul>
@if ($group->description)
<div class="well well-sm">
    <strong>{{ trans('group.description') }}</strong><br>{!! nl2br($group->description) !!}
</div>
@endif

@can('update', $group)
@if ($group->isPlanned())
    {{ Form::open([
        'route' => ['groups.set-start-date', $group],
        'method' => 'patch',
        'class' => 'form-inline',
        'style' => 'display:inline',
        'onsubmit' => 'return confirm("'.__('group.set_start_date_confirm').'")',
    ]) }}
    {!! FormField::text('start_date', ['required' => true, 'label' => false, 'placeholder' => __('group.start_date')]) !!}
    {{ Form::submit(__('group.set_start_date'), ['class' => 'btn btn-default', 'id' => 'set-start-date']) }}
    {{ Form::close() }}
@endif

@if ($group->isActive())
    {{ Form::open([
        'route' => ['groups.set-end-date', $group],
        'method' => 'patch',
        'class' => 'form-inline',
        'style' => 'display:inline',
        'onsubmit' => 'return confirm("'.__('group.set_end_date_confirm').'")',
    ]) }}
    {!! FormField::text('end_date', ['required' => true, 'label' => false, 'placeholder' => __('group.end_date')]) !!}
    {{ Form::submit(__('group.set_end_date'), ['class' => 'btn btn-default', 'id' => 'set-end-date']) }}
    {{ Form::close() }}
@endif
@endcan

@endsection

@section('styles')
    {{ Html::style(url('css/plugins/jquery.datetimepicker.css')) }}
@endsection

@push('scripts')
    {{ Html::script(url('js/plugins/jquery.datetimepicker.js')) }}
<script>
(function() {
    $('input[name="start_date"],input[name="end_date"]').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        closeOnDateSelect: true,
        scrollInput: false
    });
})();
</script>
@endpush
