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
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</en>
                        <td>{{ $category->id_category }}</td>
                    </tr>
                    <tr>
                        <th>Code</y>
                        <td>{{ $category->code_category }}</td>
                    </tr>
                    <tr>
                        <th>Name</en>
                        <td>{{ $category->name_category }}</td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('category') }}" class="btn btn-sm btn-default mt-2">Return</a>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
