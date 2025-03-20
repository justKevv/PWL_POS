@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('/sales') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Sales Code</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="sales_code" name="sales_code" value="{{
                            old('sales_code') }}" readonly required>
                        @error('sales_code')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Buyer</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="buyer" name="buyer" value="{{
                            old('buyer') }}" required>
                        @error('buyer')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Products</label>
                    <div class="col-11">
                        <table class="table table-bordered" id="products_table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control product-select" name="id_product[]" id="id_product" required>
                                            <option value="">- Select Product -</option>
                                            @foreach($product as $item)
                                                <option value="{{ $item->id_product }}">{{ $item->product_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control price-input" name="price[]" id="price" readonly required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" name="qty[]" id="quantity" required>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm remove-product" type="button">Remove</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-success btn-sm" id="add_product" type="button">Add Product</button>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">User</label>
                    <div class="col-11">
                        <select class="form-control" id="id_user" name="id_user" required>
                            <option value="">- Select User -</option>
                            @foreach($user as $item)
                                <option value="{{ $item->id_user }}">{{ $item->username }}</option>
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
                        <input type="date" class="form-control" id="sales_date" name="sales_date" value="{{
                            old('sales_date', date('Y-m-d')) }}" required>
                        <input type="hidden" id="sales_date_time" name="sales_date_time">
                        @error('sales_date')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('/sales') }}">Return</a>
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
        $(document).ready(function () {
            generateSalesCode();

            $('#sales_date').on('change', function() {
                generateSalesCode();
            });

            $('form').on('submit', function() {
                var selectedDate = $('#sales_date').val();
                var now = new Date();
                var time = now.getHours().toString().padStart(2, '0') + ':' +
                          now.getMinutes().toString().padStart(2, '0') + ':' +
                          now.getSeconds().toString().padStart(2, '0');
                $('#sales_date_time').val(selectedDate + ' ' + time);
            });

            function generateSalesCode() {
                var date = $('#sales_date').val();

                if (date) {
                    $.ajax({
                        url: "{{ url('/sales/getNextCode') }}/" + date,
                        type: "GET",
                        success: function(data) {
                            var dateParts = date.split('-');
                            var code = 'SALE/' + dateParts[0] + '/' +
                                     dateParts[1] + '/' +
                                     dateParts[2] + '/' +
                                     data.next_code.toString().padStart(3, '0');
                            $('#sales_code').val(code);
                        }
                    });
                } else {
                    $('#sales_code').val('');
                }
            }

            $(document).on('change', '.product-select', function() {
                var selectedProduct = $(this).val();
                var priceInput = $(this).closest('tr').find('.price-input');
                if (selectedProduct) {
                    $.ajax({
                        url: "{{ url('/sales/getProductPrice') }}/" + selectedProduct,
                        type: "GET",
                        success: function(data) {
                            priceInput.val(data.price);
                        }
                    });
                } else {
                    priceInput.val('');
                }
            })

            $('#add_product').click(function() {
                var newRow = $('#products_table tbody tr:first').clone();
                newRow.find('input').val('');
                newRow.find('select').val('');
                $('#products_table tbody').append(newRow);
            })

            $(document).on('click', '.remove-product', function() {
                if ($('#products_table tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                }
            })
        });
    </script>
@endpush
