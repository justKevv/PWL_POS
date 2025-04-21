@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-title">{{ $page->title }}</div>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/category/import') }}')" class="btn btn-sm btn-info mt-1">Import Category</button>
                <a href="{{ url('/category/create') }}" class="btn btn-sm btn-primary mt-1"> + Add</a>
                <button onclick="modalAction('{{ url('category/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Add Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_category">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
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
        var dataCategory;
        $(document).ready(function() {
            dataCategory = $('#table_category').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('/category/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "code_category",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "name_category",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "action",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
