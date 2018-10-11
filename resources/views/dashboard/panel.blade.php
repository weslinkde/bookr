@if (Gate::allows('admin'))
    <li class="sidebar-header"><span>Admin</span></li>
    <li class="nav-item @if(Request::is('book', 'book/*')) active @endif">
        <a class="nav-link" href="{!! url('book') !!}"><span class="fas fa-tachometer-alt"></span> Book Assets</a>
    </li>
    <li class="nav-item @if(Request::is('admin/users', 'admin/users/*')) active @endif">
        <a class="nav-link" href="{!! url('admin/users') !!}"><span class="fas fa-users"></span> Users</a>
    </li>
    <li class="nav-item @if(Request::is('admin/roles', 'admin/roles/*')) active @endif">
        <a class="nav-link" href="{!! url('admin/roles') !!}"><span class="fas fa-lock"></span> Roles</a>
    </li>
@endif