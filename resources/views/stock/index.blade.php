@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-title">{{ $page->title }}</div>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('stock/import_ajax') }}')" class="btn btn-sm btn-info mt-1">Import</button>
                <a href="{{ url('/stock/create') }}" class="btn btn-sm btn-primary mt-1"> + Add</a>
                <button onclick="modalAction('{{ url('stock/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Add Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_stock">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Username</th>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url='') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var dataStock; // Ensure dataStock is accessible for reload
        $(document).ready(function() {
            dataStock = $('#table_stock').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('/stock/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "product.product_name",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "user.username",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "date_stock",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "stock_quantity",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "action",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });
        });
    </script>
@endpush
