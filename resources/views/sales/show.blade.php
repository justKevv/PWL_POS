@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty ($sales)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    The data you are looking for is not found.
                </div>
            @else
                <h5>Sales Information</h5>
                <table class="table table-bordered table-striped table-hover table-sm mb-4">
                    <tr>
                        <th width="200">Sales Code</th>
                        <td>{{ $sales->sales_code }}</td>
                    </tr>
                    <tr>
                        <th>Buyer</th>
                        <td>{{ $sales->buyer }}</td>
                    </tr>
                    <tr>
                        <th>Sales Date</th>
                        <td>{{ $sales->sales_date }}</td>
                    </tr>
                    <tr>
                        <th>Staff</th>
                        <td>{{ $sales->user->username }}</td>
                    </tr>
                </table>

                <h5>Sales Details</h5>
                <table class="table table-bordered table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales->detail as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->product->product_name }}</td>
                                <td>{{ $detail->price }}</td>
                                <td>{{ $detail->qty }}</td>
                                <td>{{ $detail->subtotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th>{{ $sales->total }}</th>
                        </tr>
                    </tfoot>
                </table>
            @endempty
            <a href="{{ url('sales') }}" class="btn btn-sm btn-default mt-2">Return</a>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
