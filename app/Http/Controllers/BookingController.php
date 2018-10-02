<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookings;

class BookingController extends Controller
{
    public function index()
    {
        return view('booking.list', ['bookings' => Bookings::orderBy('start_time')]);
    }

    public function create()
    {
        return view('booking.create');
    }

    public function store(Request $request)
    {
        $time = explode(" - ", $request->input('time'));

        $booking = new Bookings;
        $booking->name = $request->input('name');
        $booking->title = $request->input('title');
        $booking->start_time = $time[0];
        $booking->end_time = $time[0];
        $booking->save();

        $request->session()->flash('succes', 'The booking was made succesfully.');
        return redirect('booking.create');
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

        return redirect('assets');
    }
}
