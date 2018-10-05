<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookings;
use Illuminate\Support\Facades\DB;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Dotenv\Validator;

class BookingController extends Controller
{

    public function calendar()
    {
        $booking = Bookings::orderBy('id');
        return view('booking.calendar', compact('booking'));
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
        return url('/calendar');
    }

    public function update(Request $request, $id)
    {
        $time = explode(" - ", $request->input('time'));
        $booking = Bookings::findOrFail($id);
        $booking->name = $request->input('name');
        $booking->title = $request->input('title');
        $booking->start_time = $time[0];
        $booking->end_time = $time[1];
        $booking->save();

        return redirect('assets');
    }

    public function destroy($id)
    {
        $booking = Bookings::find($id);
        $booking->delete();

        return redirect('bookings');
    }
}
