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
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="choose flex-column">
                        <div class="d-flex flex-column justify-content-center assets">
                            <h2><span class="fas fa-users"></span> Teams</h2>
                            <div class="card raw-margin-bottom-24">
                                <div class="card-header mb-0 d-flex"><p class="mb-0">Your Team(s)</p> <a
                                            href="{{url('teams/create')}}" class="ml-auto">Create Team</a></div>
                                <div class="card-body">
                                    <?php $i = 0; ?>
                                    @foreach(\App\Models\Team::all() as $team)
                                        @if($user->isTeamMember($team->id))
                                            <?php $i++; ?>
                                            <ul>
                                                <li style="list-style: none;"><a
                                                            href="{{url('/teams/'.$team->id.'/show')}}"><span
                                                                class="fas fa-users"></span> {{ $team->name }}</a>
                                                    <ul>
                                                        @foreach($team->members as $member)
                                                            <li>
                                                                <i class="far fa-user"></i> {{$member->name}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            </ul>
                                        @endif
                                    @endforeach
                                    @if($i == 0)
                                        <p>You are not part of a team yet, you can create one by clicking <a
                                                    href="{{url('teams/create')}}">Create Team</a>.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php($k = 0)
            <div class="col-xs-12 col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="choose flex-column">
                        <div class="d-flex flex-column justify-content-center assets">
                            <div class="col-md-12 d-flex">
                                <h2 style="margin-left: -10px;"><span class="far fa-calendar-alt"></span> Calendars</h2>
                                <a href="{{url('calendar/create')}}" class="ml-auto mt-2">Create a new Calendar</a>
                            </div>
                            @if(count($calendars) > 0)
                                @foreach($calendars as $calendar)
                                    @php($k++)
                                    @if ($user->isTeamMember($team->id))
                                        <div class="card raw-margin-bottom-5">
                                            <div class="card-header" id="heading{{$calendar->id}}"
                                                 data-toggle="collapse" data-target="#collapse{{$calendar->id}}"
                                                 aria-expanded="true" aria-controls="collapse{{$calendar->id}}">
                                                <div class="mb-0 d-flex">
                                                    <button class="btn btn-link" style="padding-left: 0;">
                                                        {{$calendar->name}}
                                                    </button>
                                                    @if($user->isTeamAdmin($team->id))
                                                    <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}"
                                                       class="ml-auto mt-2">Create a new Asset</a>
                                                        <a href="{{url('calendar/'.$calendar->id.'/edit')}}" class="mt-2 ml-3">Edit Calendar</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div id="collapse{{$calendar->id}}" class="collapse show"
                                                 aria-labelledby="heading{{$calendar->id}}" data-parent="#accordion">
                                                @if(count($assets) > 0)
                                                    <div class="card-body">
                                                        <table class="col-md-12">
                                                            @foreach($assets as $asset)
                                                                @if($calendar->id == $asset->calendar_id)
                                                                    <tr>
                                                                        <td>
                                                                            <a href="{{url('book/'.$asset->id)}}">{{$asset->name}}</a>
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
                                                                        @endif
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                @else
                                                    <p style="margin: 20px;">No Assets were found for in this Calendar, you can create Assets <a href="{{url('calendar/'.$calendar->id.'/asset/create')}}">here</a>.</p>
                                                @endif
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
                                    <div class="card-header" id="heading" data-toggle="collapse" data-target="#collapse"
                                         aria-expanded="true" aria-controls="collapse">
                                        <div class="mb-0 d-flex">
                                            <p class="mb-0">No Calendar found</p>
                                        </div>
                                    </div>
                                    <div id="collapse" class="collapse show"
                                         aria-labelledby="heading" data-parent="#accordion">
                                        <p style="margin: 20px;">No Calendars were found, you can create one <a
                                                    href="{{url('calendar/create')}}">here</a>.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
