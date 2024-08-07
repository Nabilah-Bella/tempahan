@extends('layouts.system')

@section('top_script')
    <link href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
@endsection

@section('title')
    <span>
        DASHBOARD
    </span>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body" style="height: 130px;">
                    <center>
                        <h1>{{ $total_booking }}</h1>
                        Total Booking
                    </center>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body" style="height: 130px;">
                    <center>
                        <h1>{{ $total_booking_pending }}</h1>
                        Total Booking Pending
                    </center>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body" style="height: 130px;">
                    <center>
                        <h1>{{ $total_booking_approved }}</h1>
                        Total Booking Approved
                    </center>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body" style="height: 130px;">
                    <center>
                        <h1>{{ $total_user }}</h1>
                        Total Users
                    </center>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div id="my_chart" style="height: 200px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div id="my_chart_2" style="height: 200px;"></div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Room Name</th>
            <th>Date</th>
            <th>Status</th>
            <th>Submited At</th>
        </tr>

        @php($i = 0)
        @foreach ($latest as $booking)
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
                <td>
                    {{ $booking->created_at->format('d F Y h:i:s') }}<br>
                    {{ $booking->created_at->diffForHumans() }}
                </td>
            </tr>
        @endforeach
    </table>

    {{-- https://morrisjs.github.io/morris.js/#getting-started --}}
    <script type="text/javascript">
        $(document).ready(function() {
            new Morris.Bar({
                element: 'my_chart',
                data: [
                    @foreach ($graph as $data)
                        {
                            month: '{{ $data['month_name'] }}',
                            value: {{ $data['total_booking'] }}
                        },
                    @endforeach
                ],
                xkey: 'month',
                ykeys: ['value'],
                labels: ['Value']
            });

            new Morris.Donut({
                element: 'my_chart_2',
                data: [{
                        label: 'Pending',
                        value: {{ $total_booking_pending }}
                    },
                    {
                        label: 'Approved',
                        value: {{ $total_booking_approved }}
                    },
                ],
                colors: ['#dbb732', '#1a9140'],
            });
        });
    </script>
@endsection
