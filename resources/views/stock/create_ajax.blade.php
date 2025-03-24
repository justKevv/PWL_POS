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

<form action="{{ url('/stock/ajax') }}" method="POST" id="form-add">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Product</label>
                    <div>
                        <select class="form-control" id="id_product" name="id_product" required>
                            <option value="">- Select Product -</option>
                            @foreach($product as $item)
                                <option value="{{ $item->id_product }}">{{ $item->product_name }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_product" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label>User</label>
                    <div>
                        <select class="form-control" id="id_user" name="id_user" required>
                            <option value="">- Select User -</option>
                            @foreach($user as $item)
                                <option value="{{ $item->id_user }}">{{ $item->username }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_user" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <div>
                        <input type="date" class="form-control" id="date_stock" name="date_stock"
                            value="{{ old('date_stock', date('Y-m-d')) }}" required>
                        <input type="hidden" id="date_time_stock" name="date_time_stock">
                        <small id="error-date_stock" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <div>
                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
                        <small id="error-stock_quantity" class="error-text form-text text-danger"></small>
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
    $(document).ready(function() {
        $("#form-add").validate({
            rules: {
                id_product: { required: true },
                id_user: { required: true },
                date_stock: { required: true },
                stock_quantity: { required: true, number: true }
            },
            submitHandler: function(form) {
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
                            dataStock.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
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
