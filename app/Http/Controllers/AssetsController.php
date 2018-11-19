<?php

namespace App\Http\Controllers;

use App\Calendars;
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
        return view('booking.choose', compact('assets', 'calendars', 'user'));
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
        if (Assets::where('name', $request['name'])->exists()) {
            return redirect('assets/create')->withErrors('This Asset already exists');
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
        $asset_id = $request->route()->parameter('id');
        $asset = Assets::find($asset_id);
        return view('assets.edit', compact('asset'));
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
        $asset_id = $request->route()->parameter('id');
        $asset = Assets::where('id', $asset_id);
        if (Assets::where('name', $request['name'])->exists()) {
            return redirect('assets/edit/'. $asset_id)->withErrors('This Asset could not be updated, This Asset already exists');
        } else {
            $asset = Assets::find($asset_id);
            $booking = Bookings::where('id', $asset->id)->get();
            $title = $asset->name;
            foreach ($booking as $book) {
                $book->title = $title;
                $book->save();
            }
            $asset->name = $request['name'];
            $asset->save();
            return redirect('assets/edit')->with('message', 'Succesfully updated ' . $asset->name);
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
        $asset_id = $request->route()->parameter('id');
        $asset = Assets::find($asset_id);
        Bookings::where('assetId', $asset_id)->delete();
        $asset->delete();

        return redirect('assets/edit')->with('message', 'Succesfully deleted ' . $asset->name);
    }
}
