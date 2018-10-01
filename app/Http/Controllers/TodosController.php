<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TodoService;
use App\Http\Requests\TodoCreateRequest;
use App\Http\Requests\TodoUpdateRequest;

class TodosController extends Controller
{
    public function __construct(TodoService $todo_service)
    {
        $this->service = $todo_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $todos = $this->service->paginated();
        return view('todos.index')->with('todos', $todos);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $todos = $this->service->search($request->search);
        return view('todos.index')->with('todos', $todos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\TodoCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoCreateRequest $request)
    {
        $result = $this->service->create($request->except('_token'));

        if ($result) {
            return redirect(route('todos.edit', ['id' => $result->id]))->with('message', 'Successfully created');
        }

        return redirect(route('todos.index'))->withErrors('Failed to create');
    }

    /**
     * Display the todo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = $this->service->find($id);
        return view('todos.show')->with('todo', $todo);
    }

    /**
     * Show the form for editing the todo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = $this->service->find($id);
        return view('todos.edit')->with('todo', $todo);
    }

    /**
     * Update the todos in storage.
     *
     * @param  App\Http\Requests\TodoUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TodoUpdateRequest $request, $id)
    {
        $result = $this->service->update($id, $request->except('_token'));

        if ($result) {
            return back()->with('message', 'Successfully updated');
        }

        return back()->withErrors('Failed to update');
    }

    /**
     * Remove the todos from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->service->destroy($id);

        if ($result) {
            return redirect(route('todos.index'))->with('message', 'Successfully deleted');
        }

        return redirect(route('todos.index'))->withErrors('Failed to delete');
    }
}
