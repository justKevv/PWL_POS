@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty ($stock)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    The data you are looking for is not found.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</en>
                        <td>{{ $stock->id_stock }}</td>
                    </tr>
                    <tr>
                        <th>Product Name</en>
                        <td>{{ $stock->product->product_name }}</td>
                    </tr>
                    <tr>
                        <th>Username</en>
                        <td>{{ $stock->user->username }}</td>
                    </tr>
                    <tr>
                        <th>Date</y>
                        <td>{{ $stock->date_stock }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</en>
                        <td>{{ $stock->stock_quantity }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('stock') }}" class="btn btn-sm btn-default mt-2">Return</a>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
