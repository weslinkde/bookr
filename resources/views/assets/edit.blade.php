@extends('dashboard')

@section('pageTitle') Edit Asset: {{$asset->name}} @stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Warning!</strong>
                <br> When you edit an asset, the descriptions of bookings from that asset will not update.
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-5" style="margin: 0 auto;">
                    {{ Form::open(['method' => 'PATCH', 'url' => 'assets/update/' . $asset->id]) }}
                    @csrf
                    <div class="row">
                        <div class="col-md-12 raw-margin-top-24">
                            <label>Name</label>
                            {{ Form::text('name', $value = $asset->name, ['class' => 'form-control', 'value' => $asset->name]) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 raw-margin-top-24">
                            <div class="d-flex">
                                <div class="ml-auto p-2">
                                    {{ Form::submit('Edit', ['class' => 'btn btn-primary']) }}
                                    {{ Form::close() }}
                                </div>
                                <script>

                                    function ConfirmDelete()
                                    {
                                        var x = confirm("Are you sure you want to delete this Asset?");
                                        if (x)
                                            return true;
                                        else
                                            return false;
                                    }

                                </script>
                                <div class="p-2">
                                    {{ Form::open(['method' => 'DELETE', 'url' => 'assets/delete/' . $asset->id, 'onsubmit' => 'ConfirmDelete()']) }}
                                    @csrf
                                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex">
                                <div class="p-2" style="margin-top: -45px;">
                                    <a href="{{url('book')}}">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop