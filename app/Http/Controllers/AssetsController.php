<?php

namespace App\Http\Controllers;

use function GuzzleHttp\Psr7\uri_for;
use Illuminate\Http\Request;
use App\Assets;
use App\Bookings;
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
        $error = "";
        return view('assets.create', compact('error'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Assets::where('name', $request['name'])->exists()) {
            $error = "This Asset or href already exists.";
            return view('assets.create', compact('error'));
        } else {
            $booking = new Assets();
            $booking->name = $request['name'];
            $booking->save();
            return redirect('book');
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
            return redirect('assets/edit/'. $asset_id);
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
            return redirect('assets/edit');
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

        return redirect('assets/edit');
    }
}
