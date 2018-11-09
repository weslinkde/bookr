<?php

namespace App\Http\Controllers\Admin;

use App\Bookings;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserInviteRequest;
use App\Models\Role;

class UserController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    //Display a listing of the resource.
    public function index()
    {
        $users = $this->service->all();
        return view('admin.users.index')->with('users', $users);
    }

    //Display a listing of the resource searched.
    public function search(Request $request)
    {
        if (! $request->search) {
            return redirect('admin/users');
        }
        $users = $this->service->search($request->search);
        return view('admin.users.index')->with('users', $users);
    }

    //Show the form for inviting a customer.
    public function getInvite()
    {
        return view('admin.users.invite');
    }

    //Show the form for inviting a customer.
    public function postInvite(UserInviteRequest $request)
    {
        $result = $this->service->invite($request->except(['_token', '_method']));
        if ($result) {
            return redirect('admin/users')->with('message', 'Successfully invited');
        }
        return back()->with('errors', ['Failed to invite']);
    }

    //Switch to a different User profile
    public function switchToUser($id)
    {
        if ($this->service->switchToUser($id)) {
            return redirect('book')->with('message', 'You\'ve switched users.');
        }

        return redirect('book')->with('errors', ['Could not switch users']);
    }

    //Switch back to your original user
    public function switchUserBack()
    {
        if ($this->service->switchUserBack()) {
            return back()->with('message', 'You\'ve switched back.');
        }
        return back()->with('errors', ['Could not switch back']);
    }

    //Show the form for editing the specified resource.
    public function edit($id)
    {
        $user = $this->service->find($id);
        return view('admin.users.edit')->with('user', $user);
    }

    //Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $result = $this->service->update($id, $request->except(['_token', '_method']));
        if ($result) {
            return back()->with('message', 'Successfully updated');
        }
        return back()->with('errors', ['Failed to update']);
    }

    //Remove the specified resource from storage.
    public function destroy($id)
    {
        Bookings::where('user_id', $id)->delete();
        $this->service->destroy($id);
        return redirect('admin/users')->with('message', 'Successfully deleted');
    }
}
