<!-- Nav tabs -->
<ul class="nav nav-tabs">
    <li class="{{ Request::segment(3) == null ? 'active' : '' }}">
        {!! link_to_route('groups.show', trans('group.detail'), [$group]) !!}
    </li>
    <li class="{{ Request::segment(3) == 'members' ? 'active' : '' }}">
        {!! link_to_route('groups.members.index', trans('group.members'), [$group]) !!}
    </li>
</ul>
<br>
