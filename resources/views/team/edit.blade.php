@extends('dashboard')

@section('pageTitle') Teams: Edit @stop

@section('content')

    <div class="row">
        <div class="col-md-12 raw-margin-bottom-24">
            <div>
                @if (Auth::user()->isTeamAdmin($team->id) || Gate::allows('admin'))
                    <form method="post" action="{{ url('teams/'.$team->id) }}">
                        {!! csrf_field() !!}
                        {!! method_field('delete') !!}
                        <button type="submit" class="btn btn-danger pull-right raw-margin-bottom-4 ml-2">Delete Team</button>
                    </form>
                    <a class="btn btn-primary pull-right raw-margin-bottom-4" href="{{url('team/'.$team->id.'/invite')}}">Invite members</a>
                @endif
                <form method="post" action="{{ url('teams/'.$team->id) }}">
                    {!! csrf_field() !!}
                    {!! method_field('PATCH') !!}

                    @form_maker_object($team, ['name' => 'string'])
                    @form_maker_object($team, ['description' => 'string'])

                    <div class="raw-margin-top-24">
                        <a class="btn btn-secondary pull-left" href="{{ url('teams/'.$team->id.'/show') }}">Cancel</a>
                        <button class="btn btn-primary pull-right" type="submit">Save</button>
                    </div>

                </form>
            </div>
        </div>
        @if (Auth::user()->isTeamAdmin($team->id))
            <div class="col-md-12 raw-margin-top-24">
                <h2 class="text-left">Members</h2>
                @if ($team->members->isEmpty())
                    <div class="col-md-12 raw-margin-bottom-24">
                        <div class="well text-center">No members found.</div>
                    </div>
                @else
                    <table class="table table-striped">
                        <thead>
                            <th>Name</th>
                            <th>Role</th>
                            <th class="text-right">Action</th>
                        </thead>
                        <tbody>
                            @foreach($team->members as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>
                                        @if ($team->user_id == $member->id)
                                            Team Owner
                                        @else
                                            Member
                                        @endif
                                    </td>
                                    <td>
                                        @if (! $member->isTeamAdmin($team->id))
                                            <a class="btn btn-danger pull-right btn-xs" href="{{ url('teams/'.$team->id.'/remove/'.$member->id) }}" onclick="return confirm('Are you sure you want to remove this member?')">Remove</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endif
    </div>

@stop

