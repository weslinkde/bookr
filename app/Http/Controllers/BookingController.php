<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookings;
use Illuminate\Support\Facades\DB;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Dotenv\Validator;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{

    public function calendar()
    {
        $user = Auth::user();
        $columns = [
            'id AS id',
            'start_time AS start',
            'end_time AS end',
            'title AS title',
            'name AS name'
        ];
        $allBookings = Bookings::get($columns);
        $bookings = $allBookings->toJson();
        return view('booking.calendar', compact('bookings', 'user'));
    }

    public function store(Request $request)
    {
        $booking = new Bookings;
        $booking->name = $request['name'];
        $booking->title = $request['title'];
        $booking->start_time = $request['start_time'];
        $booking->end_time = $request['end_time'];
        $booking->save();
        $request->session()->flash('succes', 'The booking was made succesfully.');
        return view('booking.calendar');
    }

    public function update(Request $request, $id)
    {
        $booking = Bookings::find($id);
        $booking->start_time = $request['start_time'];
        $booking->end_time = $request['end_time'];
        $booking->save();


    }

    public function destroy($id)
    {
        $booking = Bookings::find($id);
        $booking->delete();

        return view('booking.calendar');
    }
}
