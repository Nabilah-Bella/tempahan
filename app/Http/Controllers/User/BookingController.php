<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User();
        $rooms = Room::where('status', 1)->orderBy('name', 'ASC')->get();
        $bookings = Booking::where('user_id', $user->id)->orderBy('booking_date', 'ASC')->get();

        return view('user.room_index', compact('rooms', 'bookings'));
    }

    public function booking($id)
    {
        $room = Room::find($id);
        $user = Auth::User();

        return view('user.room_booking', compact('room', 'user'));
    }

    public function bookingPost(Request $request, $id)
    {
        $this->validate($request, [
            'booking_date' => 'required|date_format:Y-m-d',

        ]);

        $user = Auth::User();
        $room = Room::find($id);
        $booking = new Booking;

        if ($room) {
            $booking->user_id = $user->id;
            $booking->room_id = $room->id;
            $booking->booking_date = $request['booking_date'];
            $booking->save();

            return redirect()->route('user.room.index');
        }
    }

    public function bookingCancel($id)
    {
        $user = Auth::User();
        // $booking = Booking::find($id);
        $booking = Booking::where('user_id', $user->id)->where('id', $id)->where('status', 0)->first();

        if ($booking) {
            $booking->delete();
        }

        return redirect()->route('user.room.index');
    }
}
