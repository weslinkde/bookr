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

        .asset {
            display: flex;
            flex-direction: column;


            line-height: 50px;
            margin-bottom: 20px;

            text-align: center;
            border: 1px solid #C3C3C3;
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
                        <h1 class="col-12" style="font-size: 28px; text-align: center; margin-top: 50px; margin-bottom: 40px;">Choose
                            what you want you want to reservate.</h1>
                        <div class="d-flex flex-column justify-content-center assets">
                            @if(count($assets) > 0)
                                @foreach(array_chunk($assets->all(), 3) as $asset)
                                    <div class="row">
                                        @foreach($asset as $item)
                                            <a href="{{url('book/' . $item->id)}}" class="col-xs-10 col-md-4 assets">
                                                <span class="asset">{{$item->name}}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach
                            @else
                                <p style="margin: 0 auto; font-size: 20px;">No Assets were found.</p>
                            @endif
                                @if (Gate::allows('admin'))
                                    <row style="margin: 30px auto">
                                        <a href="{{url('assets/create')}}" class="btn btn-primary" style="width: 155px;">Create an Asset.</a>
                                        <a href="{{url('assets/edit')}}" class="btn btn-primary" style="width: 155px;">Edit an Asset.</a>
                                    </row>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
