@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty ($product)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    The data you are looking for is not found.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</en>
                        <td>{{ $product->id_product }}</td>
                    </tr>
                    <tr>
                        <th>Product Code</en>
                        <td>{{ $product->product_code }}</td>
                    </tr>
                    <tr>
                        <th>Name</en>
                        <td>{{ $product->product_name }}</td>
                    </tr>
                    <tr>
                        <th>Level</y>
                        <td>{{ $product->category->name_category }}</td>
                    </tr>
                    <tr>
                        <th>Purchase Price</en>
                        <td>{{ $product->purchase_price }}</td>
                    </tr>
                    <tr>
                        <th>Selling Price</th>
                        <td>{{ $product->selling_price }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('item') }}" class="btn btn-sm btn-default mt-2">Return</a>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
