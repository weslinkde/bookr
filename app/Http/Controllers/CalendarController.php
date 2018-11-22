<?php

namespace App\Http\Controllers;

use App\Calendars;
use App\Services\TeamService;
use function GuzzleHttp\Psr7\uri_for;
use Illuminate\Http\Request;
use App\Assets;
use App\Bookings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CalendarController extends Controller
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
    public function index()
    {
        $calendars = Calendars::orderBy('name', 'asc')->get();
        $assets = Assets::orderBy('name', 'asc')->get();
        return view('booking.choose', compact('assets', 'calendars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $teams = $this->service->all($user->id);
        return view('calendar.create', compact('teams', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Calendars::where('name', $request['name'])->where('team_id', $request['team_id'])->exists()) {
            return redirect('book')->withErrors('This Asset already exists');
        } else {
            $booking = new Calendars();
            $booking->team_id = $request['team_id'];
            $booking->name = $request['name'];
            $booking->save();
            return redirect('book')->with('message', 'Succesfully created ' . $booking->name);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function chooseEdit()
    {
        $assets = Assets::orderBy('name', 'asc')->get();
        return view('assets.editlist', compact('assets'));
    }

    public function edit(Request $request)
    {
        $calendar_id = $request->route()->parameter('calendar_id');
        $calendar = Calendars::find($calendar_id);
        return view('calendar.edit', compact('calendar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $calendar_id = $request->route()->parameter('calendar_id');
        if (Calendars::where('name', $request['name'])->exists()) {
            return redirect('book')->withErrors('This Calendar could not be updated, This Calendar already exists');
        }
        else {
            $calendar = Calendars::find($calendar_id);
            $calendar->name = $request['name'];
            $calendar->save();
            return redirect('book')->with('message', 'Succesfully updated ' . $calendar->name);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $calendar_id = $request->route()->parameter('calendar_id');
        Assets::where('calendar_id', $calendar_id)->delete();
        Bookings::where('assetId', $calendar_id)->delete();
        $calendar = Calendars::find($calendar_id);
        $calendar->delete();

        return redirect('book')->with('message', 'Succesfully deleted ' . $calendar->name);
    }
}
