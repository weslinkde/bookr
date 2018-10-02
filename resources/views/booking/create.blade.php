@extends('dashboard')

@section('pageTitle') Teams: Create @stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <form method="post" action="{{ route('bookings.store') }}">
                        {!! csrf_field() !!}

                        @form_maker_table("bookings", ['name' => 'string'])
                        @form_maker_table("bookings", ['title' => 'string'])
                        @form_maker_table("bookings", ['start_time' => 'time'])
                        @form_maker_table("bookings", ['end_time' => 'time'])

                        <div class="raw-margin-top-24">
                            <a class="btn btn-secondary pull-left" href="{{ url('bookings') }}">Cancel</a>
                            <button class="btn btn-primary pull-right" type="submit">Create</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@stop