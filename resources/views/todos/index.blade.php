<div class="container">

    <div class="">
        {{ Session::get('message') }}
    </div>

    <div class="row">
        <div class="pull-right">
            {!! Form::open(['route' => 'todos.search']) !!}
            <input class="form-control form-inline pull-right" name="search" placeholder="Search">
            {!! Form::close() !!}
        </div>
        <h1 class="pull-left">Todos</h1>
        <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('todos.create') !!}">Add New</a>
    </div>

    <div class="row">
        @if($todos->isEmpty())
            <div class="well text-center">No todos found.</div>
        @else
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th width="50px">Action</th>
                </thead>
                <tbody>
                @foreach($todos as $todo)
                    <tr>
                        <td>
                            <a href="{!! route('todos.edit', [$todo->id]) !!}">{{ $todo->name }}</a>
                        </td>
                        <td>
                            <a href="{!! route('todos.edit', [$todo->id]) !!}"><i class="fa fa-pencil"></i> Edit</a>
                            <form method="post" action="{!! route('todos.destroy', [$todo->id]) !!}">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this todo?')"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="row">
                {!! $todos; !!}
            </div>
        @endif
    </div>
</div>