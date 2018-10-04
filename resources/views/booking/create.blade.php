@extends('dashboard')

@section('pageTitle') Book an Asset @stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form method="post" action="{{ route('bookingStore') }}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-12 raw-margin-top-24">
                                <label>Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 raw-margin-top-24">
                                <label>Title</label>
                                <input class="form-control" type="text" name="title" placeholder="Title" id="title">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 raw-margin-top-24">
                                <label>Date</label>
                                <input class="form-control" type="date" name="date" id="date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 raw-margin-top-24">
                                <label>Start Time</label>
                                <input class="form-control" type="time" name="start_time" id="start_time">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 raw-margin-top-24">
                                <label>End Time</label>
                                <input class="form-control" type="time" name="end_time" id="end_time">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 raw-margin-top-24">
                                <div class="btn-toolbar justify-content-between">
                                    <button class="btn btn-primary" type="submit">Book</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop