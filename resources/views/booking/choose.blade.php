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
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="choose flex-column">
                        <div class="d-flex flex-column justify-content-center assets">
                            <div class="card">
                                <div class="card-header mb-0">Team</div>
                                <div class="card-body">
                                    <ul>
                                        <li>
                                            Member1
                                        </li>
                                        <li>
                                            Member2
                                        </li>
                                        <li>
                                            Member3
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="choose flex-column">
                        <div class="d-flex flex-column justify-content-center assets">
                            <div id="accordion">
                                @foreach($calendars as $calendar)
                                    @if ($user->isTeamMember($calendar->id) || Gate::allows('admin'))
                                        <div class="card">
                                            <div class="card-header" id="heading{{$calendar->id}}">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$calendar->id}}" aria-expanded="true" aria-controls="collapse{{$calendar->id}}">
                                                        {{$calendar->name}}
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapse{{$calendar->id}}" class="collapse show" aria-labelledby="heading{{$calendar->id}}" data-parent="#accordion">
                                                <div class="card-body">
                                                    @if(count($assets) > 0)
                                                        @foreach($assets as $asset)
                                                            <a href="{{url('book/'.$asset->id)}}">{{$asset->name}}</a>
                                                        @endforeach
                                                    @else
                                                        <p>No Assets were found for in this Calendar</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <a href="{{url('calendar/create')}}">Create a new calendar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
