@extends('dashboard')

@section('pageTitle') Edit list @stop

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10" style="margin: 0 auto;">
            <h1 style="margin-bottom: -40px;">Edit an Asset</h1>
            <a href="{{url('book')}}" style="float: right; margin-bottom: 10px;"><span
                        class="btn btn-primary">Back</span></a>
            <a href="{{url('assets/create')}}" style="float: right; margin-bottom: 10px; margin-right: 10px;"><span
                        class="btn btn-primary">Create an Asset</span></a>
            <table class="table table-striped">
                <thead>
                <th>Asset</th>
                <th>Number of Bookings</th>
                <th class="text-right" style="width: 300px">Actions</th>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                        <tr>
                            <td><a href="{{url('book/' . $asset->id)}}">{{ $asset->name }}</a></td>
                            <td>{{ count(\App\Bookings::where('assetId', $asset->id)->get()) }}</td>
                            <td>
                                <div class="btn-toolbar justify-content-between">
                                    <a class="btn btn-outline-primary btn-sm raw-margin-right-8"
                                       href="{{ url('assets/edit/'.$asset->id) }}"><span
                                                class="fa fa-edit"></span> Edit</a>
                                    <form method="post" action="{!! url('book/'.$asset->id.'/delete') !!}">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Are you sure you want to clear ' + {{ count(\App\Bookings::where('assetId', $asset->id)->get())}} + ' Bookings from this Asset?')">
                                            <i class="fa fa-trash"></i> Clear Bookings
                                        </button>
                                    </form>
                                    <form method="post" action="{!! url('assets/delete/'.$asset->id) !!}">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-danger btn-sm" type="submit"
                                                onclick="return confirm('Are you sure you want to delete this Asset?')">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop