@extends('dashboard')

@section('content')

    @php($z = 0)
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row">
                <div class="col-md-8">
                    <div class="col-md-12 d-flex">
                        <h2 style="margin-left: -10px; font-size: 20px;"><span class="far fa-calendar-alt"></span> Your Calendar(s)</h2>
                        <a href="{{url('calendar/create')}}" class="ml-auto mt-2">Create a new Calendar</a>
                    </div>
                    @foreach($calendars as $calendar)
                        @php($p = 0)
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
                    @if($z == 0)
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
                <div class="col-md-4">
                    <div class="col-md-12 d-flex">
                        <h2 style="margin-left: -10px; font-size: 20px;"><span class="fas fa-user"></span> Information</h2>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Personal
                            <a href="settings" class="active pull-right">Edit profile</a>
                        </div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td>Name:</td>
                                    <td>{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{$user->email}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
