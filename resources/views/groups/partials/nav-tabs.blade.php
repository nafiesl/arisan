<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('groups.show', trans('group.detail'), [$group]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'meetings' ? 'active' : '' }}">
        {!! link_to_route('groups.meetings.index', trans('group.meetings'), [$group]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'payments' ? 'active' : '' }}">
        {!! link_to_route('groups.payments.index', trans('group.outstanding_payments'), [$group]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'members' ? 'active' : '' }}">
        {!! link_to_route('groups.members.index', trans('group.members'), [$group]) !!}
    </li>
</ul>
<br>
