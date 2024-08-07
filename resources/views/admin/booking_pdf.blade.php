<html>

<head>
    <title>Booking List</title>
    <style type="text/css">
        .table {
            width: 100%;
        }

        th {
            background-color: #444;
            color: #FFF;
            font-weight: bold;
            text-align: center;

        }

        td,
        th {
            border: 1px solid #000;
            padding: 5px;
        }

        .bg-warning {
            background-color: orange;
        }

        .bg-success {
            background-color: green;
            color: #FFF;
        }

        .bg-danger {
            background-color: red;
            color: #FFF;
        }
    </style>
</head>

<body>
    <table cellpadding="0" cellspacing="0" class="table">
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Room Name</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        @php($i = 0)
        @foreach ($bookings as $booking)
            <tr>
                <td>{{ ++$i }}</td>
                <td>
                    @if ($booking->user)
                        {{ $booking->user->name }}
                    @endif
                </td>
                <td>
                    @if ($booking->room)
                        {{ $booking->room->name }}
                    @endif
                </td>
                <td>{{ $booking->booking_date }}</td>
                <td>
                    @if ($booking->status == 0)
                        <span class="badge bg-warning">Pending</span>
                    @elseif($booking->status == 1)
                        <span class="badge bg-success">Approved</span>
                    @elseif($booking->status == 2)
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
