<form action="{{ url('/item/ajax') }}" method="POST" id="form-add">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
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
                                <option value="{{ $item->id_category }}">{{ $item->name_category }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_category" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label>Product Code</label>
                    <div>
                        <input type="text" class="form-control" id="product_code" name="product_code" readonly>
                        <small id="error-product_code" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label>Product Name</label>
                    <div>
                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                        <small id="error-product_name" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label>Purchase Price</label>
                    <div>
                        <input type="number" class="form-control" id="purchase_price" name="purchase_price" required>
                        <small id="error-purchase_price" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label>Selling Price</label>
                    <div>
                        <input type="number" class="form-control" id="selling_price" name="selling_price" required>
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
    console.log('Script loaded');  // Debug line to check if script runs

    $(document).ready(function () {
        console.log('Document ready');  // Debug line to check if jQuery is ready

        $(document).on('change', '#id_category', function() {
            console.log('Change event triggered');  // Debug line to check if event triggers

            var id_category = $(this).val();
            var name_category = $(this).find('option:selected').text();
            console.log('Category ID:', id_category);
            console.log('Category Name:', name_category);

            if (id_category) {
                $.ajax({
                    url: "{{ url('/item/getNextId') }}/" + id_category,
                    type: "GET",
                    success: function(data) {
                        console.log('Response:', data);
                        var prefix = name_category.substring(0, 3).toUpperCase();
                        var number = String(data.next_id).padStart(3, '0');
                        var code = prefix + number;
                        console.log('Generated Code:', code);
                        $('#product_code').val(code);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        console.error('Status:', status);
                        console.error('Response:', xhr.responseText);
                        $('#product_code').val('');
                    }
                });
            } else {
                $('#product_code').val('');
            }
        });
        $("#form-add").validate({
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
