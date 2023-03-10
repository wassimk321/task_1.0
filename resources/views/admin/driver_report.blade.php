@extends('layouts.master')
@section('content')
    @include('layouts.partials.header')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Orders') }}</h6>
        </div>
        <div class="card-body">


            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>

                            <th>{{ __('Order Number') }}</th>
                            <th>{{ __('Driver Name') }}</th>
                            <th>{{ __('Driver ID') }}</th>
                            <th>{{ __('From Time') }}</th>
                            <th>{{ __('To Time') }}</th>
                            <th>{{ __('Distance') }}</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data['orders'] as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->driver->name }}</td>
                                <td>{{ $order->driver->id }}</td>
                                <td>
                                    @foreach ($order->orderDetails as $detail)
                                        {{ $detail->from_time }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($order->orderDetails as $detail)
                                        {{ $detail->to_time }}<br>
                                    @endforeach
                                </td>
                                <td>{{ $order->distance }}</td>
                            </tr>
                            </tr>
                        @endforeach
                        <tr>
                            <td>{{ __('Total Distance') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $data['totalDistance'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Total Hours') }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $data['totalHours'] }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@include('layouts.partials.scripts')
<script></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel']
        });
    });
</script>
