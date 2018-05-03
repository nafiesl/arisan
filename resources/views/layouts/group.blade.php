@extends('layouts.app')

@section('title')
@yield('subtitle', __('group.detail')) - {{ $group->name }}
@endsection

@section('content')
<h1 class="page-header">
    <div class="pull-right">
        @yield('action-buttons')
        {{ link_to_route('groups.index', __('group.back_to_index'), [], ['class' => 'btn btn-default']) }}
    </div>
    {{ $group->name }}
</h1>

<div class="row">
    <div class="col-md-8 col-md-push-4">
        @include('groups.partials.nav-tabs')
        @yield('content-group')
    </div>
    <div class="col-md-4 col-md-pull-8">
        <div class="panel panel-default">
            <table class="table table-condensed">
                <tbody>
                    <tr><td>{{ __('group.name') }}</td><td>{{ $group->name }}</td></tr>
                    <tr><td>{{ __('app.status') }}</td><td>{{ $group->status }}</td></tr>
                    <tr><td>{{ __('group.capacity') }}</td><td>{{ $group->capacity }}</td></tr>
                    <tr><td>{{ __('group.members') }}</td><td>{{ $group->members->count() }}</td></tr>
                    <tr>
                        <td>{{ __('group.payment_amount') }}</td>
                        <td class="text-right">{{ $group->currency }} {{ formatNo($group->payment_amount) }}</td>
                    </tr>
                    <tr><td>{{ __('group.creator') }}</td><td>{{ $group->creator->name }}</td></tr>
                    <tr><td>{{ __('group.description') }}</td><td>{{ $group->description }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
