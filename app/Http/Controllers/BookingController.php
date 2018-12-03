<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Bookings;
use App\Assets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{
    private $columnsDateTime = [
        'id AS id',
        'start_time AS start',
        'end_time AS end',
        'description AS description',
        'title AS title',
        'user_id AS user_id',
    ];
    private $columnsTime = [
        'id AS id',
        'start AS start',
        'end AS end',
        'recurring AS dow',
        'description AS description',
        'title AS title',
        'user_id AS user_id',
    ];

    public function calendar($assetId)
    {
        $myAsset = Assets::find($assetId);
        $assets = $myAsset->name;
        $user = Auth::user();
        $team = \App\Models\Team::find($user->id);

        $book = Bookings::where('assetId', $assetId)->where('start', null);
        $allBookings = $book->get($this->columnsDateTime);

        $dowBook = Bookings::where('assetId', $assetId)->where('start_time', null);
        $allDowBookings = $dowBook->get($this->columnsTime);

        $bookings = $allDowBookings->merge($allBookings)->toJson();
        return view('booking.calendar', compact('team','bookings', 'dowBookings', 'name', 'book', 'assetId', 'description', 'assetid', 'user', 'assets', 'allBookings'));
    }

    public function store(Request $request, $assetId)
    {
        $user = Auth::user();
        $booking = new Bookings;

        if($request['start_time'] == null) {
            $booking->start_time = $request['start'];
            $booking->end_time = $request['end'];
        }
        else {
            $booking->recurring = $request['recurring'];
            $booking->start = $request['start_time'];
            $booking->end = $request['end_time'];
        }

        $booking->user_id = $user->id;
        $booking->title = $request['title'];
        $booking->description = $request['description'];
        $booking->assetId = $assetId;
        $booking->save();
        $creator = User::find($booking->user_id);
        $lb = [
            'id' => $booking->id,
            'title' => $booking->title,
            'dow' => $booking->recurring,
            'start' => $booking->start_time,
            'end' => $booking->end_time,
            'start_time' => $booking->start,
            'end_time' => $booking->end,
            'description' => $booking->description,
            'user_id' => $booking->user_id,
            'creator_nicename' => $creator->name,
        ];

        return json_encode($lb);
    }

    public function update(Request $request)
    {
        $booking_id = $request->route()->parameter('id');
        $booking = Bookings::find($booking_id);
        $booking->title = $request['title'];
        $booking->description = $request['description'];

        if($request['recurring'] == null) {
            $booking->start_time = $request['start_time'];
            $booking->end_time = $request['end_time'];
        }
        else {
            $booking->recurring = $request['recurring'];
            $booking->start = $request['start_time'];
            $booking->end = $request['end_time'];
        }

        $booking->save();
        $lb = [
            'id' => $booking_id,
            'title' => $booking->title,
            'description' => $booking->description,
            'dow' => $booking->recurring,
            'start' => $booking->start_time,
            'end' => $booking->end_time,
            'start_time' => $booking->start,
            'end_time' => $booking->end,
        ];

        return json_encode($lb);
    }

    public function destroy(Request $request)
    {
        $booking_id = $request->route()->parameter('id');
        $booking = Bookings::find($booking_id);
        $booking->delete();
    }

    public function destroyAll(Request $request)
    {
        $asset_id = $request->route()->parameter('assetId');
        $bookings = Bookings::where('assetId', $asset_id);
        $bookingId = $bookings->get();
        $bookings->delete();
        return redirect('book')->with('message', count($bookingId) .' bookings have been deleted from this Asset');
    }
}
