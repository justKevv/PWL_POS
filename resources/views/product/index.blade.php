@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-title">{{ $page->title }}</div>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/item/import') }}')" class="btn btn-sm btn-info mt-1">Import Goods</button>
                <a href="{{ url('/item/export_pdf') }}" class="btn btn-sm mt-1 btn-warning"><i class="fa fa-file-pdf"></i> Export Barang</a>
                <a href="{{ url('/item/export_excel') }}" class="btn btn-sm mt-1 btn-primary"><i class="fa fa-file-excel"></i> Export Barang</a>
                <button onclick="modalAction('{{ url('item/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Add
                    Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="id_category" name="id_category" required>
                                <option value="">- All -</option>
                                @foreach($category as $item)
                                    <option value="{{ $item->id_category }}">{{ $item->name_category }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Item Category</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_item">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Purchase Price</th>
                        <th>Selling Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')

@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        var dataProduct;
        $(document).ready(function () {
            dataProduct = $('#table_item').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('/item/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.id_category = $('#id_category').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "product_code",
                        className: "",
                        width: "10%",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "product_name",
                        className: "",
                        width: "10%",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "category.name_category",  // Changed to access through relationship
                        className: "",
                        width: "14%",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "purchase_price",
                        className: "",
                        width: "10%",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return new Intl.NumberFormat('id-ID').format(data);
                        }
                    }, {
                        data: "selling_price",
                        className: "",
                        width: "10%",
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return new Intl.NumberFormat('id-ID').format(data);
                        }
                    }, {
                        data: "action",
                        className: "",
                        width: "14%",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#id_category').change(function () {
                dataProduct.ajax.reload();
            });
        });
    </script>
@endpush
