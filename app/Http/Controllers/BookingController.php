<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use PDF;
use App\Exports\BookingList;
use Illuminate\Contracts\Session\Session;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $room_id = isset($_GET['room_id']) ? $_GET['room_id'] : "ALL";
        $month = isset($_GET['month']) ? $_GET['month'] : "ALL";
        $year = isset($_GET['year']) ? $_GET['year'] : "ALL";
        $search = isset($_GET['search']) ? $_GET['search'] : null;

        $bookings = Booking::query();

        if ($room_id != 'ALL') {
            $bookings = $bookings->where('room_id', $room_id);
        }

        if ($month != 'ALL') {
            $bookings = $bookings->whereMonth('booking_date', $month);
        }

        if ($year != 'ALL') {
            $bookings = $bookings->whereYear('booking_date', $year);
        }

        if ($search) {
            // $bookings = $bookings->whereYear('remark', 'LIKE', '%' . $search . '%'); // straight forward
            $bookings = $bookings->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                    $query->orWhere('email', 'LIKE', '%' . $search . '%');
                })->orWhereHas('room', function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search . '%');
                });
            });
        }

        $bookings = $bookings->paginate(6);

        $rooms = Room::orderBy('name', 'ASC')->get();

        return view('admin.booking_index', compact('bookings', 'rooms', 'room_id', 'month', 'year', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        // $booking = Booking::find($id);
        return view('admin.booking_show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);

        $booking = Booking::find($id);

        if ($request['action'] == 'approve') {
            $booking->status = 1;
            Session()->flash('message', 'Booking has been successfully approved!');
        } elseif ($request['action'] == 'reject') {
            $booking->status = 2;
            Session()->flash('message', 'Booking has been rejected!');
        }

        $booking->save();

        return redirect()->route('admin.booking.index', ['page' => $request['page']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pdf()
    {
        $bookings = Booking::all();
        $pdf = PDF::loadView('admin.booking_pdf', compact('bookings'));

        return $pdf->setPaper('a4', 'landscape')->stream('booking_list.pdf');
    }

    public function excel()
    {
        return Excel::download(new BookingList, 'booking_list.xlsx');
    }
}
