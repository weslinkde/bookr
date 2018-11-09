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
    private $columns = [
        'id AS id',
        'start_time AS start',
        'end_time AS end',
        'description AS description',
        'title AS title',
        'user_id AS user_id',
    ];

    public function calendar($assetId)
    {
        $myAsset = Assets::find($assetId);
        $assets = $myAsset->name;
        $user = Auth::user();
        $book = Bookings::where('assetId', $assetId);
        $allBookings = $book->get($this->columns);
        $bookings = $allBookings->toJson();
        return view('booking.calendar', compact('bookings', 'name', 'book', 'assetId', 'description', 'assetid', 'user', 'assets'));
    }

    public function store(Request $request, $assetId)
    {
        $user = Auth::user();
        $booking = new Bookings;
        $booking->user_id = $user->id;
        $booking->title = $request['title'];
        $booking->description = $request['description'];
        $booking->assetId = $assetId;
        $booking->start_time = $request['start'];
        $booking->end_time = $request['end'];
        $booking->save();
        $creator = User::find($booking->user_id);
        $lb = [
            'id' => $booking->id,
            'title' => $booking->title,
            'start' => $booking->start_time,
            'end' => $booking->end_time,
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
        $booking->description = $request['description'];
        $booking->start_time = $request['start_time'];
        $booking->end_time = $request['end_time'];
        $booking->save();
        $lb = [
            'id' => $booking_id,
            'description' => $booking->description,
            'start' => $booking->start_time,
            'end' => $booking->end_time,
        ];
        return json_encode($lb);
    }

    public function updateDescription(Request $request)
    {
        $booking_id = $request->route()->parameter('id');
        $booking = Bookings::find($booking_id);
        $booking->description = $request['description'];
        $booking->save();
        $lb = [
            'id' => $booking_id,
            'description' => $booking->description,
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
        return redirect('assets/edit')->with('message', count($bookingId) .' bookings have been deleted from this Asset');
    }
}
