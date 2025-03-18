@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty ($product)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    The data you are looking for is not found.
                </div>
                <a href="{{ url('item') }}" class="btn btn-sm btn-default mt-2">Return</a>
            @else
                <form method="POST" action="{{ url('/item/' . $product->id_category) }}" class="form-horizontal">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Level</label>
                        <div class="col-11">
                            <select class="form-control" id="id_category" name="id_category" required>
                                <option value="">- Select Level -</option>
                                @foreach($category as $item)
                                    <option value="{{ $item->id_category }}" @if($item->id_category == $product->id_category) selected
                                    @endif>
                                        {{ $item->name_category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_category')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Username</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="product_code" name="product_code"
                                value="{{ old('product_code', $product->product_code) }}" readonly>
                            @error('product_code')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Name</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                value="{{ old('product_name', $product->product_name) }}" required>
                            @error('product_name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Purchase Price</label>
                        <div class="col-11">
                            <input type="number" 1 class="form-control" id="purchase_price" name="purchase_price"
                             value="{{ old('purchase_price', $product->purchase_price) }}" required>
                            @error('purchase_price')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Selling Price</label>
                        <div class="col-11">
                            <input type="number" class="form-control" id="selling_price" name="selling_price"
                            value="{{ old('selling_price', $product->selling_price) }}"  required>
                            @error('selling_price')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('item') }}">Return</a>
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
            $('#id_category').on('change', function () {
                var id_category = $(this).val();
                var name_category = $(this).find('option:selected').text();

                if (id_category) {
                    $.ajax({
                        url: "{{ url('/item/getNextId') }}/" + id_category,
                        type: "GET",
                        success: function (data) {
                            var prefix = name_category.substring(0, 3).toUpperCase();
                            var number = String(data.next_id).padStart(3, '0');
                            $('#product_code').val(prefix + number);
                        }
                    });
                } else {
                    $('#product_code').val('');
                }
            })
        })
    </script>
@endpush
