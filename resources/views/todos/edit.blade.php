<div class="">
    {{ Session::get('message') }}
</div>

<div class="container">

    {!! Form::model($todo, ['route' => ['todos.update', $todo->id], 'method' => 'patch']) !!}

    @form_maker_object($todo, FormMaker::getTableColumns('todos'))

    {!! Form::submit('Update') !!}

    {!! Form::close() !!}
</div>
