@extends('dashboard')

@section('content')
    <style>
        body .fc {
            overflow: auto;
            touch-action: manipulation;
        }

        .assets, .options {
            color: black;
            text-decoration: none;
        }

        .assets:hover {
            color: black;
            text-decoration: none;
        }

        .options:hover {
            text-decoration: none;
            color: dodgerblue;
        }

        .asset {
            display: flex;
            flex-direction: column;

            margin: 5px;
            line-height: 50px;
            vertical-align: middle;

            border: 1px solid #C3C3C3;
            border-radius: 15px;
            background-color: #E0E0E0;
        }

        .asset:hover {
            background-color: #e8e8e8;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="choose flex-column">
                        <h1 class="col-12" style="text-align: center; margin-top: 50px; margin-bottom: 40px;">Choose
                            what you want you want to reservate.</h1>
                        <div class="d-flex flex-sm-column justify-content-center assets" align="center">
                            @if($assets)
                                @foreach($assets as $asset)
                                    <a href="{{url('book/' . $asset->href)}}" class="col-xs-10 col-md-6 m-2 assets">
                                        <span class="asset">
                                            {{$asset->name}}
                                        </span>
                                    </a>
                                    @if (Gate::allows('admin'))
                                        <a href="{{url('assets/edit/' . $asset->id)}}" class="options" style="width: 180px">Edit {{$asset->name}} <i class="far fa-edit"></i></a>
                                    @endif
                                @endforeach
                            @else
                                <p>No Assets found.</p>
                            @endif
                        </div>
                        @if (Gate::allows('admin'))
                            <a href="{{url('assets/create')}}" class="btn btn-primary" style="width: 180px">Create an Asset.</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection