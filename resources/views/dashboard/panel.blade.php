<li class="sidebar-header" style="margin-top: -1px;"><span>Menu</span></li>
<li class="nav-item @if(Request::is('dashboard', 'dashboard/*')) active @endif">
    <a class="nav-link" href="{!! url('dashboard') !!}"><span class="fas fa-tachometer-alt"></span> Dashboard</a>
</li>
<li class="nav-item @if(Request::is('user/settings', 'user/password')) active @endif">
    <a class="nav-link" href="{!! url('user/settings') !!}"><span class="fas fa-user"></span> Settings</a>
</li>
<li class="nav-item @if(Request::is('Room1', 'Room1/*')) active @endif">
    <a class="nav-link" href="{!! url('book/Room1') !!}"><span class="fas fa-users"></span> Book room 1</a>
</li>
<li class="nav-item @if(Request::is('Room2', 'Room2/*')) active @endif">
    <a class="nav-link" href="{!! url('book/Room2') !!}"><span class="fas fa-users"></span> Book room 2</a>
</li>
<li class="nav-item @if(Request::is('Beamer', 'Beamer/*')) active @endif">
    <a class="nav-link" href="{!! url('book/Beamer') !!}"><span class="fas fa-users"></span> Book the beamer</a>
</li>
<li class="nav-item @if(Request::is('calendar', 'calendar/*')) active @endif">
    <a class="nav-link" href="{!! url('calendar') !!}"><span class="fas fa-users"></span> Booking etc</a>
</li>
@if (Gate::allows('admin'))
    <li class="sidebar-header"><span>Admin</span></li>
    <li class="nav-item @if(Request::is('admin/dashboard', 'admin/dashboard/*')) active @endif">
        <a class="nav-link" href="{!! url('admin/dashboard') !!}"><span class="fas fa-tachometer-alt"></span> Dashboard</a>
    </li>
    <li class="nav-item @if(Request::is('admin/users', 'admin/users/*')) active @endif">
        <a class="nav-link" href="{!! url('admin/users') !!}"><span class="fas fa-users"></span> Users</a>
    </li>
    <li class="nav-item @if(Request::is('admin/roles', 'admin/roles/*')) active @endif">
        <a class="nav-link" href="{!! url('admin/roles') !!}"><span class="fas fa-lock"></span> Roles</a>
    </li>
@endif