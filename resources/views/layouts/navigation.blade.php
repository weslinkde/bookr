<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    @if(Gate::allows('admin'))<a class="sidebar-toggle page-title navbar-text text-light ml-3 mr-3"><i class="fa fa-bars"></i></a>
    @endif
    <a class="navbar-brand mr-0" href="{{url('book')}}">Asset Reservations</a>
    <ul class="navbar-nav mr-auto">
        <span class="navbar-text raw-margin-left-24 page-title">
            @yield('pageTitle')
        </span>
    </ul>
    <ul class="navbar-nav flex-row px-3">
        <li class="nav-item text-nowrap">
            @if (Auth::user())
                <a class="nav-link" href="/logout">Sign out</a>
            @endif
        </li>
    </ul>
</nav>
