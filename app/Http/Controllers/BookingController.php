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

    public function calendar($assetId)
    {
        $myAsset = Assets::find($assetId);
        $assets = $myAsset->name;
        $user = Auth::user();
        $columns = [
            'id AS id',
            'start_time AS start',
            'end_time AS end',
            'description AS description',
            'title AS title',
            'user_id AS user_id',
        ];
        $book = Bookings::where('assetId', $assetId);
        $allBookings = $book->get($columns);
        $bookings = $allBookings->toJson();
        return view('booking.calendar', compact('bookings','name', 'book', 'assetId', 'description', 'assetid', 'user', 'assets'));
    }

    public function store(Request $request, $assetId)
    {
        $user = Auth::user();
            $booking = new Bookings;
            $booking->user_id = $user->id;
            $booking->title = $request['title'];
            $booking->description = $request['description'];
            $booking->assetId = $assetId;
            $booking->start_time = $request['start_time'];
            $booking->end_time = $request['end_time'];
        $booking->save();
        return view('booking.calendar');
    }

    public function update(Request $request)
    {
        $booking_id = $request->route()->parameter('id');
        $booking = Bookings::find($booking_id);
        $booking->start_time = $request['start_time'];
        $booking->end_time = $request['end_time'];
        $booking->save();
        return view('booking.calendar');
    }

    public function destroy(Request $request)
    {
        $booking_id = $request->route()->parameter('id');
        $booking = Bookings::find($booking_id);
        $booking->delete();

        return view('booking.calendar');
    }
}
