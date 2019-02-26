@extends('dashboard')

@section('pageTitle') Create a Calendar @stop

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row justify-content-center">
                <div class="col-md-6 col-md-offset-4">
                    <form method="post" action="{{ url('calendar/store') }}" id="calendarForm">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-12 raw-margin-top-24">
                                <label>Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Name" id="name">
                                <br>
                                    <label>Personal?</label>
                                    <input type="checkbox" name="personal" value="personal?">
                                <br>
                                    <label>Teams</label>
                                    <select name="team_id" form="calendarForm">
                                        <option selected="selected" value="{{null}}">none</option>
                                        @foreach($teams as $team)
                                            @if($user->isTeamMember($team->id))
                                                <option value="{{$team->id}}">{{$team->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 raw-margin-top-24">
                                <div class="btn-toolbar justify-content-between">
                                    <button class="btn btn-primary" type="submit">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop