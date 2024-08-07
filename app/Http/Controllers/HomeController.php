<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        // $total_booking = Booking::where('status', 0)->count();
        $total_booking = Booking::count();
        $total_booking_pending = Booking::where('status', 0)->count();
        $total_booking_approved = Booking::where('status', 1)->count();
        $total_user = User::count();
        $total_room = Room::count();

        $latest = Booking::orderBy('created_at', 'DESC')->take(6)->get(); //utk keluarkan listing

        $graph = [];
        $year = date('Y');

        // https://carbon.nesbot.com/docs/ --untuk date guna carbon
        for ($i = 1; $i <= 12; $i++) {
            $date = Carbon::createFromDate($year, $i, 1);

            $graph[$i]['month_name'] = $date->format('m');
            $graph[$i]['total_booking'] = Booking::whereMonth('booking_date', $i)->whereYear('booking_date', $year)->count();
        }

        return view('admin.dashboard', compact('total_booking', 'total_booking_pending', 'total_booking_approved', 'total_user', 'total_room', 'latest', 'graph'));
    }

    public function dashboardUser()
    {
        return view('user.dashboard');
    }
}
