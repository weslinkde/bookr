<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookings;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class BookingController extends Controller
{

    public function calendar()
    {

        return view('booking.calendar');
    }

    public function index()
    {
        $bookings = Bookings::all();
        session()->flash('Succesfully collected all bookings');
        return view('booking.list')->with('bookings', $bookings);
    }

    public function create()
    {
        return view('booking.create');
    }

    public function store(Request $request)
    {
        $booking = new Bookings;
        $booking->name = $request->input('name');
        $booking->title = $request->input('title');
        $booking->date = $request->input('date');
        $booking->start_time = $request->input('start_time');
        $booking->end_time = $request->input('end_time');
        $booking->save();

        $request->session()->flash('succes', 'The booking was made succesfully.');
        return view('booking.list');
    }

    public function show($id)
    {
        return view('bookings.view', ['booking' => Bookings::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view('assets.edit', ['booking' => Bookings::findOrFail($id)]);
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
