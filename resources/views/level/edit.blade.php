@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty ($level)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                The data you are looking for is not found.
            </div>
            <a href="{{ url('level') }}" class="btn btn-sm btn-default mt-2">Return</a>
        @else
            <form method="POST" action="{{ url('/level/'.$level->id_level) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Level</label>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Code</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="code_level" name="code_level"
                            value="{{ old('code_level', $level->code_level) }}" readonly>
                        @error('code_level')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Name</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="name_level" name="name_level"
                            value="{{ old('name_level', $level->name_level) }}" required>
                        @error('name_level')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('level') }}">Return</a>
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
    $(document).ready(function() {
        $('#name_level').on('input', function() {
            var name = $(this).val();
            var consonants = name.replace(/([aiueo])/gi, '').replace(/[^a-z]/gi, '');
            var code = consonants.substring(0, 3).toUpperCase();

            $('#code_level').val(code);
        })
    })
</script>
@endpush
