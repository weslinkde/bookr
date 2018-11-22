<?php

namespace App\Http\Controllers;

use App\Calendars;
use App\Models\Team;
use App\Models\User;
use function GuzzleHttp\Psr7\uri_for;
use Illuminate\Http\Request;
use App\Assets;
use App\Bookings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendars = Calendars::orderBy('name', 'asc')->get();
        $assets = Assets::orderBy('name', 'asc')->get();
        $user = Auth::user();
        $i = 0;
        foreach(Team::all() as $team) {
            $i++;
        }
        return view('booking.choose', compact('assets', 'calendars', 'user', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $calendar_id = $request->route()->parameter('calendar_id');
        return view('assets.create', compact('calendar_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $calendar_id = $request->route()->parameter('calendar_id');
        if (Assets::where('name', $request['name'])->where('calendar_id', $calendar_id)->exists()) {
            return redirect('book')->withErrors('This Asset already exists');
        } else {
            $booking = new Assets();
            $booking->calendar_id = $calendar_id;
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
        $asset_id = $request->route()->parameter('asset_id');
        $asset = Assets::find($asset_id);
        return view('assets.edit', compact('asset', 'calendar_id'));
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
        $asset_id = $request->route()->parameter('asset_id');
        $calendar_id = $request->route()->parameter('calendar_id');
        if (Assets::where('name', $request['name'])->where('calendar_id', $calendar_id)->exists()) {
            return redirect('book')->withErrors('This Asset could not be updated, This Asset already exists');
        } else {
            $asset = Assets::find($asset_id);
            $asset->name = $request['name'];
            $asset->save();
            return redirect('book')->with('message', 'Succesfully updated ' . $asset->name);
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
        $asset_id = $request->route()->parameter('asset_id');
        $asset = Assets::find($asset_id);
        $asset->delete();

        return redirect('book')->with('message', 'Succesfully deleted '.$asset->name);
    }
}
