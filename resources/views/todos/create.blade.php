<div class="">
    {{ Session::get('message') }}
</div>

<div class="container">

    {!! Form::open(['route' => 'todos.store']) !!}

    @form_maker_table("todos")

    {!! Form::submit('Save') !!}

    {!! Form::close() !!}

</div>