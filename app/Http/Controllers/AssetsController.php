<?php

namespace App\Http\Controllers;

use function GuzzleHttp\Psr7\uri_for;
use Illuminate\Http\Request;
use App\Assets;
use App\Bookings;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Assets::orderBy('name', 'asc')->get();
        return view('booking.choose', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $booking = new Assets;
        $booking->name = $request['name'];
        $booking->href = $request['href'];
        $booking->save();
        return redirect('book');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $asset_id = $request->route()->parameter('id');
        $asset = Assets::find($asset_id);
        return view('assets.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $asset_id = $request->route()->parameter('id');
        $asset = Assets::find($asset_id);
        Bookings::where('type', $asset->href)->delete();
        $asset->name = $request['name'];
        $asset->href = $request['href'];
        $asset->save();
        return redirect('book');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $asset_id = $request->route()->parameter('id');
        $asset = Assets::find($asset_id);
        $type = $asset->href;
        Bookings::where('type', $type)->delete();
        $asset->delete();

        return redirect('book');
    }
}
