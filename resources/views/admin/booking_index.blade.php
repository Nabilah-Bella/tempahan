@extends('layouts.system')

@section('title')
    <span>MANAGE BOOKING</span>
@endsection

@section('content')
    @if (Session::has('message'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-success">
                    {{ Session::get('message') }}
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-3">
            <select class="form-control mb-2" id="room_id" name="room_id" onchange="filter()">
                <option @if ($room_id == 'ALL') selected @endif value="ALL">All Room</option>
                @foreach ($rooms as $room)
                    <option @if ($room_id == $room->id) selected @endif value="{{ $room->id }}">
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control mb-2" id="month" name="month" onchange="filter()">
                <option @if ($month == 'ALL') selected @endif value="ALL">All Month</option>
                <option @if ($month == '1') selected @endif value="1">January</option>
                <option @if ($month == '2') selected @endif value="2">February</option>
                <option @if ($month == '3') selected @endif value="3">March</option>
                <option @if ($month == '4') selected @endif value="4">April</option>
                <option @if ($month == '5') selected @endif value="5">May</option>
                <option @if ($month == '6') selected @endif value="6">June</option>
                <option @if ($month == '7') selected @endif value="7">July</option>
                <option @if ($month == '8') selected @endif value="8">August</option>
                <option @if ($month == '9') selected @endif value="9">September</option>
                <option @if ($month == '10') selected @endif value="10">October</option>
                <option @if ($month == '11') selected @endif value="11">November</option>
                <option @if ($month == '12') selected @endif value="12">December</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control mb-2" id="year" name="year" onchange="filter()">
                <option @if ($year == 'ALL') selected @endif value="ALL">All Year</option>
                <option @if ($year == 2023) selected @endif value="2023">2023</option>
                <option @if ($year == 2024) selected @endif value="2024">2024</option>
                <option @if ($year == 2025) selected @endif value="2025">2025</option>
            </select>
        </div>
        <div class="col-md-2">
            <input class="form-control" id="search" name="search" onkeyup="search(event)" type="text"
                value="{{ $search }}">
        </div>
        <div class="col-md-3">
            <a class="btn btn-primary" href="{{ route('admin.booking.pdf') }}" target="_blank">PDF</a>&nbsp;
            <a class="btn btn-info" href="{{ route('admin.booking.excel') }}" target="_blank">Excel</a>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Room Name</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        {{-- @php($i = 0) --}}
        @php($i = ($bookings->currentPage() - 1) * $bookings->perPage())
        @foreach ($bookings as $booking)
            <tr>
                <td>{{ ++$i }}</td>
                <td>

                    {{ $booking->user->name }}

                </td>
                <td>

                    {{ $booking->room->name }}

                </td>
                <td>
                    <a href=" {{ route('admin.booking.show', $booking->id) }}"> {{ $booking->booking_date }}
                </td>

                <td>
                    @if ($booking->status == 0)
                        <span class="badge bg-warning">Pending</span>
                    @elseif($booking->status == 1)
                        <span class="badge bg-success">Approved</span>
                    @elseif($booking->status == 2)
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
                <td>
                    @if ($booking->status == 0)
                        <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                            <input name="_method" type="hidden" value="PUT">
                            <input name="page" type="hidden" value="{{ isset($_GET['page']) ? $_GET['page'] : 1 }}">
                            @csrf
                            <button class="btn btn-success btn-sm" name="action"
                                onclick="return confirm('Are you sure to approve this booking?');" type="submit"
                                value="approve">
                                Approve
                            </button>
                            <button class="btn btn-danger btn-sm" name="action"
                                onclick="return confirm('Are you sure to reject this booking?');" type="submit"
                                value="reject">
                                Reject
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    {!! $bookings->appends($_GET)->render() !!}

    <script type="text/javascript">
        function filter() {
            var room_id = document.getElementById("room_id").value;
            var month = document.getElementById("month").value;
            var year = document.getElementById("year").value;
            var search = document.getElementById("search").value;

            self.location = "?room_id=" + room_id + "&month=" + month + "&year=" + year + "&search=" + search;
        }

        function search(e) {
            var key = e.keyCode || e.which;

            if (key == 13) {
                filter();
            }
        }
    </script>
@endsection
