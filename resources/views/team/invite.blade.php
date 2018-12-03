@extends('dashboard')

@section('pageTitle') {{$team->name}} Invite @stop

@section('content')

    <style>
        .tooltipTrigger {
            color: dodgerblue;
            cursor: pointer;
            position: relative;
            display: inline-block;
        }
        .tooltipTrigger .tooltiptext {
            display: none;
            background-color: white;
            color: black;
            border: 1px solid lightgray;
            text-align: center;
            border-radius: 6px;
            padding: 5px;

            /* Position the tooltip */
            position: absolute;
            z-index: 1;
            top: 100%;
            left: 25%;
            margin-left: -60px;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-4 col-md-offset-4">
                    <form method="post" action="{{ url('teams/'.$team->id.'/show') }}">
                        {!! csrf_field() !!}

                        @form_maker_table("invite", ['email' => 'string'])
                        <div class="tooltipTrigger raw-margin-bottom-40" onclick="invitelink()">
                            No email? Send an invite link instead!
                            <div class="tooltiptext" id="invitelink">{{$url}}</div>
                        </div>

                        <div class="raw-margin-top-24">
                            <a class="btn btn-secondary pull-left" href="{{ url('teams/'.$team->id.'/show') }}">Cancel</a>
                            <button class="btn btn-primary pull-right" type="submit">Create</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function invitelink() {
            var inviteBox = document.getElementById("invitelink");
            inviteBox.style.display = "block";
        }
    </script>
@stop