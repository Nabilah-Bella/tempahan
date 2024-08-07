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
    <br>
    <br>
    <table cellpadding="0" cellspacing="0" class="table">
        <tr>
            <th style="border:1px solid #000; background-color: #336699; color: #FFF; font-weight: bold; width:5">#</th>
            <th style="border:1px solid #000; background-color: #336699; color: #FFF; font-weight: bold; width:30">User
                Name</th>
            <th style="border:1px solid #000; background-color: #336699; color: #FFF; font-weight: bold; width:30">Room
                Name</th>
            <th style="border:1px solid #000; background-color: #336699; color: #FFF; font-weight: bold; width:20">Date
            </th>
            <th style="border:1px solid #000; background-color: #336699; color: #FFF; font-weight: bold; width:20">Status
            </th>
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

                @if ($booking->status == 0)
                    <td style="background-color: #fcba03; color: #FFFFFF; text-align: center;">
                        Pending
                    </td>
                @elseif($booking->status == 1)
                    <td style="background-color: #008746; color: #FFFFFF; text-align: center;">
                        Approved
                    </td>
                @else($booking->status == 2)
                    <td style="background-color: #870000; color: #FFFFFF; text-align: center;">
                        Rejected
                    </td>
                @endif

            </tr>
        @endforeach
    </table>
</body>

</html>
