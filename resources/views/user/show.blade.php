@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty ($user)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    The data you are looking for is not found.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</en>
                        <td>{{ $user->id_user }}</td>
                    </tr>
                    <tr>
                        <th>Level</y>
                        <td>{{ $user->level->name_level }}</td>
                    </tr>
                    <tr>
                        <th>Username</en>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Password</en>
                        <td></td>
                    </tr>
                </table>
            @endempty
            <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Return</a>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
