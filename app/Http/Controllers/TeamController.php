<?php

namespace App\Http\Controllers;

use App\Assets;
use App\Bookings;
use App\Calendars;
use App\Invite;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Gate;
use App\Models\Role;
use Illuminate\Notifications;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Http\Request;
use App\Services\TeamService;
use App\Http\Requests\TeamCreateRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserInviteRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Notifications\InviteTeamMember;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function __construct(TeamService $teamService)
    {
        $this->service = $teamService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teams = $this->service->paginated($request->user()->id);
        return view('team.index')->with('teams', $teams);
    }

    public function show(Request $request)
    {
        $id = $request->route()->parameter('id');
        $team = $this->service->find($id);
        $team_owner = User::where('id', $team->user_id)->get();
        $user = Auth::user();
        $calendars = Calendars::orderBy('name', 'asc')->get();
        $assets = Assets::orderBy('name', 'asc')->get();
        $bookings = Bookings::orderBy('id', 'asc')->get();

        if($user->isTeamMember($team->id) || Gate::allows('admin')) {
            return view('team.show', compact( 'team','team_owner', 'user', 'calendars', 'assets', 'bookings'));
        }
        else {
            abort(500, 'Unable to view this team, you are not a member of this team.');
        }
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $teams = $this->service->search($request->user()->id, $request->search);
        return view('team.index')->with('teams', $teams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $team = $request->route()->parameter('id');
        return view('team.create', compact('team'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\TeamCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamCreateRequest $request)
    {
        try {
            $result = $this->service->create(Auth::id(), $request->except('_token'));

            if ($result) {
                return redirect('teams/'.$result->id.'/show')->with('message', 'Successfully created');
            }

            return redirect('teams')->with('message', 'Failed to create');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified team.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByName($name)
    {
        $team = $this->service->findByName($name);

        if (Gate::allows('team-member', [$team, Auth::user()]) || Gate::allows('admin')) {
            return view('team.show')->with('team', $team);
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = $this->service->find($id);
        return view('team.edit')->with('team', $team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamUpdateRequest $request, $id)
    {
        try {
            $result = $this->service->update($id, $request->except('_token'));

            if ($result) {
                return back()->with('message', 'Successfully updated');
            }

            return back()->with('message', 'Failed to update');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = $this->service->destroy(Auth::user(), $id);

            if ($result) {
                return redirect('book')->with('message', 'Successfully deleted');
            }

            return back()->with('message', 'Failed to delete');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Invite a team member
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invite(Request $request)
    {
        $team_id = $request->route()->parameter('id');
        $team = $this->service->find($team_id);
        if(Invite::where('team_id', $team_id)->first() == null) {
            $token = new Invite();
            $token->team_id = $team->id;
            $token->token = bin2hex(random_bytes(10));
            $token->save();
        }
        else {
            $token = Invite::where('team_id', $team_id)->first();
        }

        $url = "localhost:8000/team/".$team->id."/accept/".$token->token;

        return view('team.invite', compact('team', 'url'));
    }

    public function accept(Request $request)
    {
        $team_id = $request->route()->parameter('id');
        $token = $request->route()->parameter('token');
        $team = $this->service->find($team_id);
        $user = Auth::user();
        $invite = Invite::where('token', $token)->first();
        if($user->isTeamMember($team_id)) {
            return redirect('book')->withErrors('You have already joined this team.');
        }
        else {
            if ($invite->created_at->toDateTimeString() >= Carbon::now()->subHours(2)->toDateTimeString()) {
                DB::table('team_user')->updateOrInsert(
                    ['user_id' => $user->id, 'team_id' => $team->id]
                );
                return redirect('teams/' . $team->id . '/show');
            } else {
                return redirect('book')->withErrors('Your invite token has expired.');
            }
        }
    }

    public function inviteMember(Request $request)
    {
        $team_id = $request->route()->parameter('id');
        $team = $this->service->find($team_id);
        $email = $request['email'];
        $token = Invite::where('team_id', $team_id)->first();
        $password = str_random(16);
        $role = Role::where('label', 'Member')->first();

        $url = "/team/".$team->id."/accept/".$token->token;

        $member = User::where('email', $email)->first();
        $newMember = null;

        if($member !== null) {
            $member->notify(new InviteTeamMember($url, $team, $member, $newMember, $password));
            return redirect('teams/'.$team->id.'/show')->with('message', 'Invitation send to '.$request['email']);
        }

        if($member == Auth::user()) {
            return redirect('teams/'.$team->id.'/show')->withErrors("You can't invite yourself to your team.");
        }
        else {
            $newMember = new User();
            $newMember->email = $email;
            $newMember->name = "Guest-".str_random(16);
            $newMember->password = bcrypt($password);
            $newMember->save();

            DB::table('role_user')->insert(
                ['user_id' => $newMember->id, 'role_id' => $role->id]
            );

            $newMember->notify(new InviteTeamMember($url, $team, $member, $newMember, $password));
            return redirect('teams/'.$team->id.'/show')->with('message', 'Invitation send to '.$request['email']);
        }
    }

    /**
     * Remove a team member
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function removeMember($id, $userId)
    {
        try {
            $result = $this->service->remove(Auth::user(), $id, $userId);

            if ($result) {
                return back()->with('message', 'Successfully removed member');
            }

            return back()->with('message', 'Failed to remove member');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
