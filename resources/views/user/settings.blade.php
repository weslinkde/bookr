@extends('dashboard')

@section('pageTitle') Settings @stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="/user/settings">
                {!! csrf_field() !!}

                <div>
                    @input_maker_label('Email')
                    @input_maker_create('email', ['type' => 'string'], $user)
                </div>

                <div class="raw-margin-top-24">
                    @input_maker_label('Name')
                    @input_maker_create('name', ['type' => 'string'], $user)
                </div>

                @if (Gate::allows('admin'))
                    <div class="raw-margin-top-24">
                        @input_maker_label('Role')
                        @input_maker_create('roles', ['type' => 'relationship', 'model' => 'App\Models\Role', 'label' => 'label', 'value' => 'name'], $user)
                    </div>
                @endif

                <div class="raw-margin-top-24">
                    <div class="btn-toolbar">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <a class="btn btn-link" href="/user/password">Change Password</a>
                        <a class="btn btn-secondary ml-auto" href="profile">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
