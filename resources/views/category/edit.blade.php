@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty ($category)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    The data you are looking for is not found.
                </div>
                <a href="{{ url('category') }}" class="btn btn-sm btn-default mt-2">Return</a>
            @else
                <form method="POST" action="{{ url('/category/' . $category->id_category) }}" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Level</label>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Code</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="code_category" name="code_category"
                                value="{{ old('code_category', $category->code_category) }}" readonly>
                            @error('code_category')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Name</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="name_category" name="name_category"
                                value="{{ old('name_category', $category->name_category) }}" required>
                            @error('name_category')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('category') }}">Return</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            $('#name_category').on('input', function () {
                var name = $(this).val();
                var consonants = name.split(' ')
                var code = consonants[0].toUpperCase();

                $('#code_category').val(code);
            })
        })
    </script>
@endpush
