@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-title">{{ $page->title }}</div>
            <div class="card-tools">
                <a href="{{ url('/user/create') }}" class="btn btn-sm btn-primary mt-1"> + Add</a>
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
                            <select class="form-control" id="id_level" name="id_level" required>
                                <option value="">- All -</option>
                                @foreach($level as $item)
                                    <option value="{{ $item->id_level }}">{{ $item->name_level }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Filter</small>
                        </div>
                    </div>
                </div>
            </div>

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
                    "data": function(d) {
                        d.id_level = $('#id_level').val();
                    }
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
            });

            $('#id_level').change(function() {
                dataUser.ajax.reload();
            });
        });
    </script>
@endpush
