@extends('layouts.system_user')

@section('title')
<span>AVAILABLE ROOM</span>
@endsection

@section('content')
<div class="row">
    @foreach($rooms as $room)
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>{{ $room->name }}</h5>
                <img src="{{ asset('uploads/photos/'.$room->photo) }}" style="width: 100%;">
                <ul>
                    <li>Room Size: {{ $room->size }}</li>
                    <li>Status: {{ $room->status }}</li>
                </ul>
                <a href="{{ route('user.room.booking', $room->id) }}" class="btn btn-primary">Book Now</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
<br>
<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Date</th>
        <th>Room Name</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    @php($i = 0)
    @foreach($bookings as $booking)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $booking->booking_date }}</td>
        <td>{{ $booking->room->name }}</td>
        <td>
            @if($booking->status == 0)
                <span class="badge bg-warning">Pending</span>
            @elseif($booking->status == 1)
                <span class="badge bg-success">Approved</span>
            @elseif($booking->status == 2)
                <span class="badge bg-danger">Rejected</span>
            @endif
        </td>
        <td>
            @if($booking->status == 0)
                <a href="{{ route('user.booking.cancel', $booking->id) }}" onclick="return confirm('Are you sure to cancel this booking?')" class="btn btn-danger btn-sm">Cancel</a>
            @endif
        </td>
    </tr>
    @endforeach
</table>
@endsection