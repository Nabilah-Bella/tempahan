@extends('layouts.system_user')

@section('title')
<span>AVAILABLE ROOM</span>
@endsection

@section('content')
<div class="row">
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5>{{ $room->name }}</h5>
                <img src="{{ asset('uploads/photos/'.$room->photo) }}" style="width: 100%;">
                <ul>
                    <li>Room Size: {{ $room->size }}</li>
                    <li>Status: {{ $room->status }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <form method="POST" action="{{ route('user.room.booking.post', $room->id) }}">
            @csrf
            <table class="table table-bordered">
                <tr>
                    <td>
                        Name 
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Email
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Date
                    </td>
                    <td>
                        <input type="date" class="form-control" name="booking_date" value="{{ old('booking_date') }}">
                        @error('booking_date')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </td>
                </tr>
            </table>

            <button type="submit" class="btn btn-primary">Submit Booking</button>
        </form>
    </div>
</div>
@endsection