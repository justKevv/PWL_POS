<script>
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
    });
</script>

@empty ($product)
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
                <a href="{{ url('/item') }}" class="btn btn-warning">Return</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/item/' . $product->id_product . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category</label>
                        <div>
                            <select class="form-control" id="id_category" name="id_category" required>
                                <option value="">- Select Category -</option>
                                @foreach($category as $item)
                                    <option value="{{ $item->id_category }}" {{ $item->id_category == $product->id_category ? 'selected' : '' }}>
                                        {{ $item->name_category }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-id_category" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Product Code</label>
                        <div>
                            <input type="text" class="form-control" id="product_code" name="product_code"
                                value="{{ $product->product_code }}" readonly>
                            <small id="error-product_code" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Product Name</label>
                        <div>
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                value="{{ $product->product_name }}" required>
                            <small id="error-product_name" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Purchase Price</label>
                        <div>
                            <input type="number" class="form-control" id="purchase_price" name="purchase_price"
                                value="{{ $product->purchase_price }}" required>
                            <small id="error-purchase_price" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Selling Price</label>
                        <div>
                            <input type="number" class="form-control" id="selling_price" name="selling_price"
                                value="{{ $product->selling_price }}" required>
                            <small id="error-selling_price" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#form-edit").validate({
                rules: {
                    id_category: { required: true },
                    product_code: { required: true },
                    product_name: { required: true },
                    purchase_price: { required: true, min: 0 },
                    selling_price: { required: true, min: 0 }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                });
                                dataProduct.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
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