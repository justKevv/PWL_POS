@empty($sales)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="fa-ban fa-ban icon"></i> Error!</h5>
                    Data not found
                </div>
                <a href="{{ url('/sales') }}" class="btn btn-warning">Return</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/sales/' . $sales->id_sales . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Sales</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Sales Code</label>
                        <div>
                            <input type="text" class="form-control" id="sales_code" name="sales_code"
                                value="{{ $sales->sales_code }}" readonly required>
                            <small id="error-sales_code" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Buyer</label>
                        <div>
                            <input type="text" class="form-control" id="buyer" name="buyer"
                                value="{{ $sales->buyer }}" required>
                            <small id="error-buyer" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Products</label>
                        <div>
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
                                    @foreach($sales->detail as $detail)
                                    <tr>
                                        <td>
                                            <select class="form-control product-select" name="id_product[]" required>
                                                <option value="">- Select Product -</option>
                                                @foreach($product as $item)
                                                    <option value="{{ $item->id_product }}"
                                                        {{ $item->id_product == $detail->id_product ? 'selected' : '' }}>
                                                        {{ $item->product_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control price-input" name="price[]"
                                                value="{{ $detail->price }}" readonly required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="qty[]"
                                                value="{{ $detail->qty }}" required>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm remove-product" type="button">Remove</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button class="btn btn-success btn-sm" id="add_product" type="button">Add Product</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>User</label>
                        <div>
                            <select class="form-control" id="id_user" name="id_user" required>
                                <option value="">- Select User -</option>
                                @foreach($user as $item)
                                    <option value="{{ $item->id_user }}"
                                        {{ $item->id_user == $sales->id_user ? 'selected' : '' }}>
                                        {{ $item->username }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-id_user" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <div>
                            <input type="date" class="form-control" id="sales_date" name="sales_date"
                                value="{{ date('Y-m-d', strtotime($sales->sales_date)) }}" required>
                            <input type="hidden" id="sales_date_time" name="sales_date_time">
                            <small id="error-sales_date" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
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
            });

            $('#add_product').click(function() {
                var newRow = $('#products_table tbody tr:first').clone();
                newRow.find('input').val('');
                newRow.find('select').val('');
                $('#products_table tbody').append(newRow);
            });

            $(document).on('click', '.remove-product', function() {
                if ($('#products_table tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                }
            });

            $("#form-edit").validate({
                rules: {
                    sales_code: { required: true },
                    buyer: { required: true },
                    'id_product[]': { required: true },
                    'price[]': { required: true },
                    'qty[]': { required: true },
                    id_user: { required: true },
                    sales_date: { required: true }
                },
                submitHandler: function(form) {
                    var selectedDate = $('#sales_date').val();
                    var now = new Date();
                    var time = now.getHours().toString().padStart(2, '0') + ':' +
                              now.getMinutes().toString().padStart(2, '0') + ':' +
                              now.getSeconds().toString().padStart(2, '0');
                    $('#sales_date_time').val(selectedDate + ' ' + time);

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                });
                                dataSales.ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty