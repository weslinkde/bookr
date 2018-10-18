@extends('dashboard')

@section('pageTitle') Create a new Asset @stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 col-md-offset-5" style="margin: 0 auto;">
                    @if($error != "")
                        {{$error}}
                    @endif
                    <form method="post" action="{{ route('storeAsset') }}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-12 raw-margin-top-24">
                                <label>Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 raw-margin-top-24">
                                <div class="btn-toolbar justify-content-between">
                                    <button class="btn btn-primary" type="submit">Create asset</button>
                                    <a href="{{url('book')}}">Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop