@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-title">{{ $page->title }}</div>
            <div class="card-tools">
                <a href="{{ url('/user/create') }}" class="btn btn-sm btn-primary mt-1">add</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>User Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')

@endpush

@push('js')
    <script>
        $(document).ready(function() {
            var dataUser = $('#table_user').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('/user/list') }}",
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
                        data: "username",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "name",
                        className: "",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "level.name_level",  // Changed to access through relationship
                        className: "",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "action",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            })
        });
    </script>
@endpush
