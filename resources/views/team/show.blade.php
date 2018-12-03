@extends('dashboard')

@section('pageTitle') {{$team->name}} @stop

<style>
    .calendars:hover {
        cursor: pointer;
    }

    .card-body ul li {
        list-style: none;
        margin-left: -20px;
    }
</style>
@php($i = 0)
@php($u = 0)
@php($o = 0)
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row">
                <div class="col-sm-7 col-md-8" style="padding: 0;">
                    <div class="col-md-12 raw-margin-bottom-24">
                        <div class="col-md-12 d-flex">
                            <h2 style="margin-left: -10px;">Calendars</h2>
                            @if($user->isTeamAdmin($team->id) || Gate::allows('admin'))
                                <a href="{{url('calendar/create')}}" class="ml-auto mt-2">Create a new Calendar</a>
                            @endif
                        </div>
                        @if(count($calendars) > 0)
                            @foreach($calendars as $calendar)
                                @if($calendar->team_id == $team->id)
                                    @php($o++)
                                    @php($k = 0)
                                    <div class="card raw-margin-bottom-4">
                                        <div class="card-header calendars" id="heading{{$calendar->id}}" data-toggle="collapse" data-target="#collapse{{$calendar->id}}" aria-expanded="true" aria-controls="collapse{{$calendar->id}}">
                                            <h5 class="mb-0 d-flex" style="font-size: 14px;">
                                                <a href="#" style="color: black; text-decoration: none;">{{$calendar->name}}</a>
                                                @if($user->isTeamAdmin($team->id) || Gate::allows('admin'))
                                                    <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}" class="ml-auto">Create a new Asset</a>
                                                @endif
                                            </h5>
                                        </div>
                                        <div id="collapse{{$calendar->id}}" class="collapse show" aria-labelledby="heading{{$calendar->id}}" data-parent="#accordion">
                                            <div class="card-body">
                                                <table class="col-md-12">
                                                    @if(count($assets) > 0)
                                                        @foreach($assets as $asset)
                                                            @if($calendar->id == $asset->calendar_id)
                                                                @php($k++)
                                                                <tr style="font-size: 14px;">
                                                                    <td>
                                                                        <a href="{{url('book/'.$asset->id)}}">{{$asset->name}}</a>
                                                                    </td>
                                                                    @if($user->isTeamAdmin($team->id) || Gate::allows('admin'))
                                                                        <td class="pull-right">
                                                                            <form action="{{url('calendar/'.$calendar->id.'/asset/'.$asset->id.'/delete')}}" method="post" style="margin: 0;">
                                                                                {!! method_field('delete') !!}
                                                                                {!! csrf_field() !!}
                                                                                <input type="submit" value="Delete" class="mb-0 btn-sm btn btn-danger ml-auto">
                                                                            </form>
                                                                        </td>
                                                                        <td class="pull-right">
                                                                            <a class="mb-0 btn btn-primary btn-sm ml-auto" href="{{url('calendar/'.$calendar->id.'/asset/'.$asset->id.'/edit')}}">Edit</a>
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                            @if($k == 0)
                                                                <p class="mb-0">No Assets were found for in this Calendar, you can create Assets <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}">here</a>.</p>
                                                            @endif
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                                @if($o == 0)
                                    <div class="card raw-margin-bottom-5">
                                        <div class="card-header">
                                            <div class="mb-0 d-flex">
                                                <button class="btn btn-link" style="padding: 0; text-decoration: none; color: black;">
                                                    No Calendars found
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">No Calendars were found, you can create Calendars <a href="{{url('calendar/create')}}">here</a>.</p>
                                        </div>
                                    </div>
                                @endif
                        @else
                            <div class="card">
                                <div class="card-header" id="heading" data-toggle="collapse" data-target="#collapse" aria-expanded="true" aria-controls="collapse">
                                    <div class="mb-0 d-flex">
                                        <button class="btn btn-link" style="padding-left: 0;">No Calendar Found</button>
                                    </div>
                                </div>
                                <div id="collapse" class="collapse show" aria-labelledby="heading" data-parent="#accordion">
                                    <div class="card-body">
                                        <p class="mb-0">No Calendars were found, you can create a Calendar <a href="{{url('calendar/create')}}">here</a>.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-5 col-md-4 align-top">
                    <div class="col-md-12 d-flex">
                        <h2 style="margin-left: -10px;">Team</h2>
                    </div>
                    @if (Auth::user()->isTeamAdmin($team->id) || Gate::allows('admin'))
                        <div class="card raw-margin-bottom-4">
                            <div class="card-header">
                                <span class="fas fa-users"></span> Team panel
                                <a href="{{url('teams/'.$team->id.'/edit')}}" class="pull-right">Edit {{$team->name}}</a>
                            </div>
                            <div class="card-body">
                                <table style="font-size: 14px;">
                                    <tr>
                                        <th style="font-size: 15px">Team Information</th>
                                    </tr>
                                    <tr>
                                        <td>Name:</td>
                                        <td>{{$team->name}}</td>
                                    </tr>
                                    @if($team->description !== null)
                                        <tr>
                                            <td>Description:</td>
                                            <td>{{$team->description}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Total members:</td>
                                        <td>{{count($team->members)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Calendars:</td>
                                        <td>
                                            @php($c = 0)
                                            @if(count($calendars) > 0)
                                                @foreach($calendars as $calendar)
                                                    @if($calendar->team_id == $team->id)
                                                        @php($c++)
                                                    @endif
                                                @endforeach
                                                    @if($c == 0)
                                                        0
                                                    @else
                                                        {{$c}}
                                                    @endif
                                            @else
                                                0
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Assets:</td>
                                        <td>
                                            @if(count($calendars) > 0)
                                                @foreach($calendars as $calendar)
                                                    @if($calendar->team_id == $team->id)
                                                        @foreach($assets as $asset)
                                                            @if($asset->calendar_id == $calendar->id)
                                                                @php($i++)
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                            @if($i !== 0)
                                                {{$i}}
                                                @else
                                                0
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Bookings:</td>
                                        <td>
                                            @if(count($assets) > 0)
                                                @foreach($assets as $asset)
                                                    @foreach($bookings as $booking)
                                                        @if($booking->assetId == $asset->id)
                                                            @php($u++)
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endif
                                            @if($u !== 0)
                                                {{$u}}
                                            @else
                                                0
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <span class="fas fa-users"></span> Team Members
                            @if (Auth::user()->isTeamAdmin($team->id) || Gate::allows('admin'))
                                <a class="inviteBtn pull-right" href="{{url('team/'.$team->id.'/invite')}}">Invite members</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" style="font-size: 14px">
                                @foreach($team->members as $member)
                                    <tr>
                                        <td style='padding-top: 20px; border: none;'><span class="fas fa-user"></span> {{ $member->name }}</td>
                                        @if (Auth::user()->isTeamAdmin($team->id) || Gate::allows('admin'))
                                            <td style="border:none;">
                                                <a class="btn btn-danger btn-sm pull-right btn-xs" href="{{ url('teams/'.$team->id.'/remove/'.$member->id) }}" onclick="return confirm('Are you sure you want to remove this member?')">Remove</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

