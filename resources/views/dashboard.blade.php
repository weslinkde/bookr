@extends('layouts.master')

@section('app-content')

    @if (Gate::allows('admin'))
    <nav id="sidebar" class="bg-light sidebar">
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                @include('dashboard.panel')
            </ul>
        </div>
    </nav>
    @endif

    <main class="pt-3 px-4 main" style="margin: auto">
        @yield('content')
    </main>

@stop
