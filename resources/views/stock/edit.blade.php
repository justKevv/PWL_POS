@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('/stock/' . $stock->id_stock) }}" class="form-horizontal">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Product</label>
                    <div class="col-11">
                        <select class="form-control" id="id_product" name="id_product" required>
                            <option value="">- Select Product -</option>
                            @foreach($product as $item)
                                <option value="{{ $item->id_product }}" {{ $stock->id_product == $item->id_product ? 'selected' : '' }}>
                                    {{ $item->product_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_product')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">User</label>
                    <div class="col-11">
                        <select class="form-control" id="id_user" name="id_user" required>
                            <option value="">- Select User -</option>
                            @foreach($user as $item)
                                <option value="{{ $item->id_user }}" {{ $stock->id_user == $item->id_user ? 'selected' : '' }}>
                                    {{ $item->username }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Date</label>
                    <div class="col-11">
                        <input type="date" class="form-control" id="date_stock" name="date_stock"
                            value="{{ old('date_stock', date('Y-m-d', strtotime($stock->date_stock))) }}" required>
                        <input type="hidden" id="date_time_stock" name="date_time_stock">
                        @error('date_stock')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Quantity</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="stock_quantity" name="stock_quantity"
                            value="{{ old('stock_quantity', $stock->stock_quantity) }}" required>
                        @error('stock_quantity')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-warning btn-sm">Update</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('/stock') }}">Return</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('form').on('submit', function() {
                var selectedDate = $('#date_stock').val();
                var now = new Date();
                var time = now.getHours().toString().padStart(2, '0') + ':' +
                          now.getMinutes().toString().padStart(2, '0') + ':' +
                          now.getSeconds().toString().padStart(2, '0');
                $('#date_time_stock').val(selectedDate + ' ' + time);
            });
        });
    </script>
@endpush
