@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-title">{{ $page->title }}</div>
            <div class="card-tools">
                <a href="{{ url('/sales/create') }}" class="btn btn-sm btn-primary mt-1"> + Add</a>
                <button onclick="modalAction('{{ url('sales/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Add Ajax</button>
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
                            <select class="form-control" id="id_user" name="id_user" required>
                                <option value="">- All -</option>
                                @foreach($user as $item)
                                    <option value="{{ $item->id_user }}">{{ $item->username }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">User Filter</small>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_sales">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sales Code</th>
                        <th>Buyer</th>
                        <th>Cashier</th>
                        <th>Date</th>
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

        var dataSales;
        $(document).ready(function () {
            dataSales = $('#table_sales').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('/sales/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.id_user = $('#id_user').val();
                    }
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "sales_code",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "buyer",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "user.username",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "sales_date",
                    className: "",
                    orderable: true,
                    searchable: false
                }, {
                    data: "action",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });

            $('#id_user').change(function() {
                dataSales.ajax.reload();
            });
        });
    </script>
@endpush
