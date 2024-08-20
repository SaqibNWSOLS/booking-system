<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\Booking\BookingStore;
use App\Models\Booking;
use App\Models\Notification;
use Auth;

class BookingController extends Controller
{

    public function index()
    {

        $query = Booking::orderBy('id', 'DESC');

        if (Auth::user()->hasRole('Client')) {

            $query->where('users_id', Auth::id());
        }

        $bookings = $query->get();

        return view('bookings.index', compact('bookings'));
    }

    public function store(BookingStore $request)
    {

        $booking = new Booking();
        $booking->users_id = $request->users_id;
        $booking->services_id = $request->services_id;
        $booking->created_by = Auth::id();

        $booking->save();

        $notification = Notification::create([
            'users_id' => 1,
            'type' => 'Booking Created',
            'data' => 'New Booking has been added.',
            'read' => 0,
        ]);
        broadcast(new NotificationEvent($notification))->toOthers();

        return back()->with('success', 'Booking has been created successfully!');
    }
}
