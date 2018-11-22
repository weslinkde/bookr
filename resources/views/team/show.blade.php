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

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="col-md-12 raw-margin-bottom-24">
                <h2 class="text-left"><span class="far fa-calendar-alt"></span> Calendars</h2>
                @if(count($calendars) > 0)
                    @foreach($calendars as $calendar)
                        @if($calendar->team_id == $team->id)
                            <div class="card raw-margin-bottom-4">
                                <div class="card-header calendars" id="heading{{$calendar->id}}" data-toggle="collapse" data-target="#collapse{{$calendar->id}}" aria-expanded="true" aria-controls="collapse{{$calendar->id}}">
                                    <h5 class="mb-0 d-flex" style="font-size: 16px;">
                                        <a href="#">
                                            {{$calendar->name}}
                                        </a>
                                        <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}" class="ml-auto">Create a new Asset</a>
                                    </h5>
                                </div>
                                <div id="collapse{{$calendar->id}}" class="collapse show" aria-labelledby="heading{{$calendar->id}}" data-parent="#accordion">
                                    <div class="card-body">
                                    <table class="col-md-12">
                                        @if(count($assets) > 0)
                                            @foreach($assets as $asset)
                                                @if($calendar->id == $asset->calendar_id)
                                                    <tr>
                                                        <td>
                                                            <a href="{{url('book/'.$asset->id)}}" style="font-size: 15px;">{{$asset->name}}</a>
                                                        </td>
                                                        @if($user->isTeamAdmin($team->id) || Gate::allows('admin'))
                                                            <td class="pull-right">
                                                                <form action="{{url('calendar/'.$calendar->id.'/asset/'.$asset->id.'/delete')}}" method="post">
                                                                    {!! method_field('delete') !!}
                                                                    {!! csrf_field() !!}
                                                                    <input type="submit" value="Delete" class="mb-0 btn btn-danger ml-auto">
                                                                </form>
                                                            </td>
                                                            <td class="pull-right">
                                                                <a class="mb-0 btn btn-primary ml-auto"
                                                                   href="{{url('calendar/'.$calendar->id.'/asset/'.$asset->id.'/edit')}}">Edit</a>
                                                            </td>
                                                        @else
                                                            <p class="mb-0">No Assets were found, you can create an Asset <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}">here</a>.</p>
                                                        @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <p class="mb-0">No Assets were found, you can create an Asset <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}">here</a>.</p>
                                        @endif
                                    </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-header" id="heading" data-toggle="collapse"
                                     data-target="#collapse" aria-expanded="true"
                                     aria-controls="collapse">
                                    <div class="mb-0 d-flex">
                                        <button class="btn btn-link" style="padding-left: 0;">No
                                            Calendar Found
                                        </button>
                                    </div>
                                </div>
                                <div id="collapse" class="collapse show" aria-labelledby="heading"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <p class="mb-0">No Calendars were found, you can create a
                                            Calendar <a href="{{url('calendar/create')}}">here</a>.</p>
                                    </div>
                                </div>
                            </div>
                            @break
                        @endif
                    @endforeach
                @else
                    <div class="card">
                        <div class="card-header" id="heading" data-toggle="collapse"
                             data-target="#collapse" aria-expanded="true"
                             aria-controls="collapse">
                            <div class="mb-0 d-flex">
                                <button class="btn btn-link" style="padding-left: 0;">No
                                    Calendar Found
                                </button>
                            </div>
                        </div>
                        <div id="collapse" class="collapse show" aria-labelledby="heading"
                             data-parent="#accordion">
                            <div class="card-body">
                                <p class="mb-0">No Calendars were found, you can create a
                                    Calendar <a href="{{url('calendar/create')}}">here</a>.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-4 ml-auto align-top">
        @if (Auth::user()->isTeamAdmin($team->id) || Gate::allows('admin'))
                <div class="card raw-margin-bottom-4">
                    <div class="card-header">
                        <span class="fas fa-users"></span> Team panel
                        <a href="{{url('teams/'.$team->id.'/edit')}}" class="pull-right">
                            Edit {{$team->name}}</a>
                    </div>
                    <div class="card-body">
                        <table>
                            <tr>
                                <th>Team Information</th>
                            </tr>
                            <tr>
                                <td>Name:</td>
                                <td>{{$team->name}}</td>
                            </tr>
                            <tr>
                                <td>Description:</td>
                                <td>{{$team->description}}</td>
                            </tr>
                            <tr>
                                <td>Total members:</td>
                                <td>{{count($team->members)}}</td>
                            </tr>
                            <tr>
                                <td>Total Calendars:</td>
                                <td>
                                    @if(count($calendars) > 0)
                                    @foreach($calendars as $calendar)
                                            @if($calendar->team_id == $team->id)
                                                {{ count(\App\Calendars::where('team_id', $team->id)->get())}}
                                                @break
                                            @else
                                                0
                                                @break
                                            @endif
                                        @endforeach
                                    @else
                                        0
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Total Assets:</td>
                                <td>{{count($assets)}}</td>
                            </tr>
                            <tr>
                                <td>Total Bookings:</td>
                                <td>
                                    @if(count($assets) > 0)
                                        @foreach($assets as $asset)
                                                {{ count(\App\Bookings::where('assetId', $asset->id)->get())}}
                                                @break
                                        @endforeach
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
                    <table class="table table-striped">
                        <thead>
                        <th>Name</th>
                        @if (Auth::user()->isTeamAdmin($team->id))
                            <th class="text-right">Action</th>
                        @endif
                        </thead>
                        <tbody>
                        @foreach($team->members as $member)
                            <tr>
                                <td style='padding-top: 20px;'><span class="fas fa-user"></span> {{ $member->name }}</td>
                                @if (Auth::user()->isTeamAdmin($team->id))
                                    <td>
                                        <a class="btn btn-danger pull-right btn-xs" href="{{ url('teams/'.$team->id.'/remove/'.$member->id) }}" onclick="return confirm('Are you sure you want to remove this member?')">Remove</a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@stop

