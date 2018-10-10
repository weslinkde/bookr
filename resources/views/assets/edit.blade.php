@extends('dashboard')

@section('pageTitle') Edit Asset: {{$asset->name}} @stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Warning!</strong><br> If you edit this asset, all the reservations in this asset will be deleted!
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-5" style="margin: 0 auto;">
                    {{ Form::open(['method' => 'PATCH', 'url' => 'assets/update/' . $asset->id]) }}
                    @csrf
                    <div class="row">
                        <div class="col-md-12 raw-margin-top-24">
                            <label>Name</label>
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'For example: Meeting Room']) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 raw-margin-top-24">
                            <label>Href <br> (No spaces, capital letters and special characters)</label>
                            {{ Form::text('href', null, ['class' => 'form-control', 'placeholder' => 'For example: beamer']) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 raw-margin-top-24">
                            <div class="btn-toolbar justify-content-between">
                                {{ Form::submit('Edit', ['class' => 'btn btn-primary']) }}
                            </div>
                            <a href="{{url('book')}}" style="float: right; margin-top: -32px;">Back</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                    <div class="row">
                        <div class="col-md-12 raw-margin-top-24">
                            {{ Form::open(['method' => 'DELETE', 'url' => 'assets/delete/' . $asset->id]) }}
                            @csrf
                            {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop