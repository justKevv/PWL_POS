<form action="{{ url('/user/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import User Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ asset('template/user_import.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download Template
                    </a>
                </div>
                <div class="form-group">
                    <label>Select File</label>
                    <input type="file" name="file_user" id="file_user" class="form-control" required>
                    <small id="error-file_user" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $("#form-import").validate({
        rules: {
            file_user: {
                required: true,
                extension: "xlsx|xls"
            }
        },
        messages: {
            file_user: {
                required: "Please select a file",
                extension: "Only Excel files (xlsx, xls) are allowed"
            }
        },
        submitHandler: function(form) {
            const formData = new FormData(form);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });
                        dataUser.ajax.reload();
                    } else {
                        $('.error-text').text('');
                        if (response.msgField) {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-'+prefix).text(val[0]);
                            });
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request'
                    });
                }
            });
            return false;
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
