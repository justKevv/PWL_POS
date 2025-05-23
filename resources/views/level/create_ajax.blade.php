<script>
    $(document).ready(function () {
        $('#name_level').on('input', function () {
            var name = $(this).val();
            var consonants = name.replace(/([aiueo])/gi, '').replace(/[^a-z]/gi, '');
            var code = consonants.substring(0, 3).toUpperCase();

            $('#code_level').val(code);
        })
    })
</script>

<form action="{{ url('/level/ajax') }}" method="POST" id="form-add">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Code</label>
                    <div>
                        <input type="text" class="form-control" id="code_level" name="code_level"
                            value="{{ old('code_level') }}" readonly>
                        <small id="error-code_level" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <div>
                        <input type="text" class="form-control" id="name_level" name="name_level"
                            value="{{ old('name_level') }}" required>
                        <small id="error-name_level" class="error-text form-text text-danger"></small>
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
                code_level: { required: true, minlength: 3, maxlength: 3 },
                name_level: { required: true, minlength: 3, maxlength: 100 }
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
                            dataLevel.ajax.reload();
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
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
