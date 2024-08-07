<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Booking;

class BookingList implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        // return view('admin.booking_excel', compact());

        return view('admin.booking_excel', ['bookings' => Booking::all()]);
    }
}
