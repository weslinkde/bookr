@extends('dashboard')

@section('content')
    <style>
        .assets {
            color: black;
            text-decoration: none;
        }

        .assets:hover {
            color: black;
            text-decoration: none;
        }

        .card-body ul li {
            list-style: none;
            margin-left: -20px;
        }

        .card-header:hover {
            cursor: pointer;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row">
                @php($p = 0)
                @php($o = 0)
                @php($u = 0)
                @php($z = 1)
                <div class="col-xs-12 col-sm-7 col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="choose flex-column">
                            <div class="d-flex flex-column justify-content-center assets raw-margin-bottom-12">
                                <div class="col-md-12 d-flex">
                                    <h2 style="margin-left: -10px; font-size: 20px;"><span class="far fa-calendar-alt"></span> Personal Calendar(s)</h2>
                                    <a href="{{url('calendar/create')}}" class="ml-auto mt-2">Create a new Calendar</a>
                                </div>
                                @foreach($calendars as $calendar)
                                    @if($user->id == $calendar->user_id)
                                        @php($z++)
                                        <div class="card raw-margin-bottom-5">
                                            <div class="card-header" id="heading{{$calendar->id}}" data-toggle="collapse" data-target="#collapse{{$calendar->id}}" aria-expanded="true" aria-controls="collapse{{$calendar->id}}">
                                                <div class="mb-0 d-flex">
                                                    <button class="btn btn-link" style="padding: 0; text-decoration: none; color: black;">
                                                        {{$calendar->name}}
                                                    </button>
                                                    <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}" class="ml-auto">Create a new Asset</a>
                                                    <a href="{{url('calendar/'.$calendar->id.'/edit')}}" class="ml-3">Edit Calendar</a>
                                                </div>
                                            </div>
                                            <div id="collapse{{$calendar->id}}" class="collapse show" aria-labelledby="heading{{$calendar->id}}" data-parent="#accordion">
                                                @if(count($assets) > 0)
                                                    <div class="card-body">
                                                        <table class="col-md-12">
                                                            @foreach($assets as $asset)
                                                                @if($calendar->id == $asset->calendar_id)
                                                                    @php($p++)
                                                                    <tr>
                                                                        <td>
                                                                            <a href="{{url('book/'.$asset->id)}}">{{$asset->name}}</a>
                                                                        </td>
                                                                        <td class="pull-right">
                                                                            <form action="{{url('calendar/'.$calendar->id.'/asset/'.$asset->id.'/delete')}}" method="post">
                                                                                {!! method_field('delete') !!}
                                                                                {!! csrf_field() !!}
                                                                                <input type="submit" value="Delete" class="mb-0 btn-sm btn btn-danger ml-auto">
                                                                            </form>
                                                                        </td>
                                                                        <td class="pull-right">
                                                                            <a class="mb-0 btn-sm btn btn-primary ml-auto" href="{{url('calendar/'.$calendar->id.'/asset/'.$asset->id.'/edit')}}">Edit</a>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </table>
                                                        @if($p == 0)
                                                            <p class="mb-0">No Assets were found for in this Calendar, you can create Assets <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}">here</a>.</p>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="card-body">
                                                        <p class="mb-0">No Assets were found for in this Calendar, you can create Assets <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}">here</a>.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @if($z == 1)
                                    <div class="card raw-margin-bottom-5">
                                        <div class="card-header">
                                            <div class="mb-0 d-flex">
                                                <button class="btn btn-link" style="padding: 0; text-decoration: none; color: black;">
                                                    No calendars found
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">No Assets were found for in this Calendar, you can create Assets <a href="{{url('calendar/create')}}">here</a>.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex flex-column justify-content-center assets raw-margin-bottom-12">
                                @foreach(\App\Models\Team::all() as $team)
                                    @if ($user->isTeamMember($team->id) || $user->isTeamAdmin($team->id) || Gate::allows('admin'))
                                        @php($u = 1)
                                        <div class="col-md-12 mt-3 d-flex">
                                            <h2 style="margin-left: -10px; font-size: 20px;"><span class="far fa-calendar-alt"></span> {{$team->name}} Calendar(s)</h2>
                                            @if($user->isTeamAdmin($team->id) || Gate::allows('admin'))
                                                <a href="{{url('calendar/create')}}" class="ml-auto mt-2">Create a new Calendar</a>
                                            @endif
                                        </div>
                                        @if(count($calendars) > 0)
                                            @foreach($calendars as $calendar)
                                                @if($team->id == $calendar->team_id)
                                                    @if($user->isTeamMember($team->id) || $user->isTeamAdmin($team->id) || Gate::allows('admin'))
                                                        @php($k = 0)
                                                        @php($u++)
                                                        <div class="card raw-margin-bottom-5">
                                                            <div class="card-header" id="heading{{$calendar->id}}" data-toggle="collapse" data-target="#collapse{{$calendar->id}}" aria-expanded="true" aria-controls="collapse{{$calendar->id}}">
                                                                <div class="mb-0 d-flex">
                                                                    <button class="btn btn-link" style="padding: 0; text-decoration: none; color: black;">
                                                                        {{$calendar->name}}
                                                                    </button>
                                                                    @if($user->isTeamAdmin($team->id) || Gate::allows('admin'))
                                                                        <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}" class="ml-auto">Create a new Asset</a>
                                                                        <a href="{{url('calendar/'.$calendar->id.'/edit')}}" class="ml-3">Edit Calendar</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div id="collapse{{$calendar->id}}" class="collapse show" aria-labelledby="heading{{$calendar->id}}" data-parent="#accordion">
                                                                @if(count($assets) > 0)
                                                                    <div class="card-body">
                                                                        <table class="col-md-12">
                                                                            @foreach($assets as $asset)
                                                                                @if($calendar->id == $asset->calendar_id)
                                                                                    @php($k++)
                                                                                    <tr>
                                                                                        <td>
                                                                                            <a href="{{url('book/'.$asset->id)}}">{{$asset->name}}</a>
                                                                                        </td>
                                                                                        @if($user->isTeamAdmin($team->id) || Gate::allows('admin'))
                                                                                            <td class="pull-right">
                                                                                                <form action="{{url('calendar/'.$calendar->id.'/asset/'.$asset->id.'/delete')}}" method="post">
                                                                                                    {!! method_field('delete') !!}
                                                                                                    {!! csrf_field() !!}
                                                                                                    <input type="submit" value="Delete" class="mb-0 btn-sm btn btn-danger ml-auto">
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="pull-right">
                                                                                                <form method="post" action="{!! url('book/'.$asset->id.'/delete') !!}">
                                                                                                    {!! csrf_field() !!}
                                                                                                    {!! method_field('DELETE') !!}
                                                                                                    <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure you want to clear ' + {{ count(\App\Bookings::where('assetId', $asset->id)->get())}} + ' Bookings from this Asset?')">
                                                                                                        Clear Bookings
                                                                                                    </button>
                                                                                                </form>
                                                                                            </td>
                                                                                            <td class="pull-right">
                                                                                                <a class="mb-0 btn-sm btn btn-primary ml-auto" href="{{url('calendar/'.$calendar->id.'/asset/'.$asset->id.'/edit')}}">Edit</a>
                                                                                            </td>
                                                                                        @endif
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </table>
                                                                        @if($k == 0)
                                                                            <p class="mb-0">No Assets were found for in this Calendar, you can create Assets <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}">here</a>.</p>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="card-body">
                                                                        <p class="mb-0">No Assets were found for in this Calendar, you can create Assets <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}">here</a>.</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                                    @if($u == 1)
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-4 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="choose flex-column">
                            <div class="d-flex flex-column justify-content-center assets">
                                <h2 style="font-size: 20px;">
                                    <span class="fas fa-users"></span> Team(s)
                                </h2>
                                <div class="card raw-margin-bottom-24">
                                    <div class="card-header mb-0 d-flex"><p class="mb-0">Your Team(s)</p> <a href="{{url('teams/create')}}" class="ml-auto">Create Team</a></div>
                                    <div class="card-body">
                                        <?php $i = 0; ?>
                                        @foreach(\App\Models\Team::all() as $team)
                                                @if($user->isTeamMember($team->id) || Gate::allows('admin'))
                                                    <?php $i++; ?>
                                                    <ul>
                                                        <li style="list-style: none;">
                                                            <a href="{{url('/teams/'.$team->id.'/show')}}"><span class="fas fa-users"></span> {{ $team->name }}</a>
                                                            <ul>
                                                                <li>
                                                                    <i class="fas fa-chess-king"></i> {{\App\Models\User::where('id', $team->user_id)->first()->name}}
                                                                    @if($team->user_id == $user->id)
                                                                        <b>(You)</b>
                                                                    @endif
                                                                </li>
                                                                @foreach($team->members as $member)
                                                                    @if($member->id !== $team->user_id)
                                                                        <li>
                                                                            <i class="far fa-user"></i> {{$member->name}}
                                                                            @if($member->id == $user->id)
                                                                                <b>(You)</b>
                                                                            @endif
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                @endif
                                            @endforeach
                                            @if($i == 0)
                                                <p>You are not part of a team yet, you can create one by clicking <a href="{{url('teams/create')}}">Create Team</a>.</p>
                                            @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection