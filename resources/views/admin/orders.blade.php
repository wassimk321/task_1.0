@extends('layouts.master')
@section('content')
    @include('layouts.partials.header')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ __('Orders') }}</h6>



        </div>
        <div class="card-body">

            <h4>{{ __('Driver Report Generation') }}</h4>

            <form method="POST" action="{{ route('report') }}">
                @csrf
                <div class="form-group">
                    <label for="date_from">Date From</label>
                    <input type="date" name="date_from" id="date_from" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="date_to">Date To</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="time_from">Time From</label>
                    <input type="time" name="time_from" id="time_from" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="time_to">Time To</label>
                    <input type="time" name="time_to" id="time_to" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="driver_id">Driver Name</label>
                    <select name="driver_id" id="driver_id" class="form-control" required>
                        @foreach ($drivers as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Generate Report') }}</button>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                        @foreach ($orders as $order)
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

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@include('layouts.partials.scripts')

{{-- <script>
    $(document).ready(function() {
        $('.delete-confirm').click(function() {
            var id = $(this).data('id');
            var route = "{{ route('products.destroy', ['product' => ':id']) }}";
            route = route.replace(':id', id);
            showDeleteConfirmation(id, route);
        });
        $('.delete-selected-confirm').click(function() {
            var id = productIds;
            if (id != '') {
                var encodedIds = encodeURIComponent(JSON.stringify(productIds));
                var decodedIds = decodeURIComponent(JSON.stringify(encodedIds));
                var route = "{{ route('products_delete') }}";
                route = route.replace(':id', decodedIds);

                deleteIds(id, route);
            }
        });
    });
</script>

<script>
    let productIds = [];

    function storeProductIds(checkbox, id) {
        if (checkbox.checked) {
            productIds.push(id);
        } else {
            productIds = productIds.filter(item => item !== id);
        }

    }
</script> --}}
