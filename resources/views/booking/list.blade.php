@extends('dashboard')

@section('pageTitle') Book Assets @stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="btn-toolbar justify-content-between">
                <a class="btn btn-primary raw-margin-right-8" href="{{ url('bookings/create') }}">Create </a>
                <form class="form-inline" method="post" action="/bookings/search">
                    {!! csrf_field() !!}
                    <input class="form-control mr-sm-2" name="search" type="search" value="{{ request('search') }}"
                           placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 raw-margin-top-24">
            <table class="table table-striped">
                <thead>
                <th>Name</th>
                <th width="165px" class="text-right">Action</th>
                </thead>
                <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->name }}</td>
                        <td>
                            <div class="btn-toolbar pull-right">
                                <form action="{{ url('/bookings/delete', ['id' => $booking->id]) }}" method="post">
                                    {!! method_field('delete') !!}
                                    {!! csrf_field() !!}
                                    <button class="btn btn-danger btn-sm" type="submit"
                                            onclick="return confirm('Are you sure you want to delete this reservation?')"><i
                                                class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop