@extends('dashboard')

@section('content')
    <style>
        body .fc {
            overflow: auto;
            touch-action: manipulation;
        }

        .assets a {
            text-decoration: none;
            color: black;
        }

        .asset {
            display: inline-flex;
            align-items: center;
            margin: 10px;
            border-radius: 10px;
            cursor: pointer;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            text-decoration: none;
            color: black;
            padding-top: -24px;
            padding-bottom: -24px;
        }

        .asset:hover {
            background-color: #a4e8b4;
        }

        .vertRow {
            flex-direction: column;
            display: inline-flex;
            align-items: right;
            margin-left: 20px;
            margin-right: -20px;
        }

        .editButton {
            padding: 2px;
        }

        .editButton:hover {
            background-color: #d4edda;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="choose flex-column">
                        <h1 class="col-12" style="text-align: center; margin-top: 50px; margin-bottom: 40px;">Choose what you want you want to reservate.</h1>
                        <div class="d-flex flex-lg-column justify-content-center assets" align="center">
                            @if($assets)
                                @foreach($assets as $asset)
                                    <div class="asset p-4" style="padding-top: -24px; padding-bottom: -24px">
                                        <div class="link">
                                            <a href="{{url('book/' . $asset->href)}}">{{$asset->name}}</a>
                                        </div>
                                        @if (Gate::allows('admin'))
                                            <div class="d-flex vertRow">
                                                <div class="edit">
                                                    <a href="{{url('assets/edit/' . $asset->id)}}" class="editButton"><i class="far fa-edit"></i></a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p>No Assets found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection