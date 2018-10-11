<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookings;
use App\Assets;
use Illuminate\Support\Facades\DB;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Dotenv\Validator;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{

    public function calendar($href)
    {
        $asset = Assets::where('href', $href)->first();
        $assets = $asset->name;
        $user = Auth::user();
        $columns = [
            'id AS id',
            'start_time AS start',
            'end_time AS end',
            'description AS description',
            'title AS title',
            'name AS name'
        ];
        $allBookings = Bookings::where('type', $href)->get($columns);
        $bookings = $allBookings->toJson();
        return view('booking.calendar', compact('bookings', 'href', 'description', 'assetid', 'user', 'assets'));
    }

    public function store(Request $request)
    {
        $booking = new Bookings;
        $booking->name = $request['name'];
        $booking->title = $request['title'];
        $booking->description = $request['description'];
        $booking->type = $request['type'];
        $booking->start_time = $request['start_time'];
        $booking->end_time = $request['end_time'];
        $booking->save();
        $request->session()->flash('succes', 'The booking was made succesfully.');
        return view('booking.calendar');
    }

    public function update(Request $request)
    {
        $booking_id = $request->route()->parameter('id');
        $booking = Bookings::find($booking_id);
        $booking->start_time = $request['start_time'];
        $booking->end_time = $request['end_time'];
        $booking->save();
    }

    public function destroy(Request $request)
    {
        $booking_id = $request->route()->parameter('id');
        $booking = Bookings::find($booking_id);
        $booking->delete();

        return view('booking.calendar');
    }
}
