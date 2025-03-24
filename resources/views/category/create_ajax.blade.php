<script>
    $(document).ready(function () {
        $('#name_category').on('input', function () {
            var name = $(this).val();
            var consonants = name.split(' ')
            var code = consonants[0].toUpperCase();

            $('#code_category').val(code);
        })
    })
</script>

<form action="{{ url('/category/ajax') }}" method="POST" id="form-add">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Code</label>
                    <div>
                        <input type="text" class="form-control" id="code_category" name="code_category"
                            value="{{ old('code_category') }}" readonly>
                        <small id="error-code_category" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <div>
                        <input type="text" class="form-control" id="name_category" name="name_category"
                            value="{{ old('name_category') }}" required>
                        <small id="error-name_category" class="error-text form-text text-danger"></small>
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
        $("#form-add").validate({
            rules: {
                code_category: { required: true },
                name_category: { required: true, minlength: 3, maxlength: 100 }
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
                            dataCategory.ajax.reload();
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
