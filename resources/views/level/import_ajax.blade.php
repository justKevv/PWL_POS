<script>
    $(document).ready(function () {
        $('#form-import').submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            let formData = new FormData(this);

            $('.error-text').text(''); // Clear previous errors

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    if (response.status === true) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success"
                        }).then((result) => {
                            dataLevel.ajax.reload(); // Reload datatable
                        });
                    } else {
                        if (response.msgField) {
                            $.each(response.msgField, function (field, errors) {
                                $('#error-' + field).text(errors.join(', '));
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message || "An error occurred during import.",
                                icon: "error"
                            });
                        }
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to process import request. " + error,
                        icon: "error"
                    });
                    console.error("Import Error:", xhr.responseText);
                }
            });
        });
    });
</script>

<form action="{{ url('/level/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Level Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="file_level">Excel File (.xlsx, .xls)</label>
                    <div>
                        <input type="file" class="form-control" id="file_level" name="file_level" accept=".xlsx, .xls" required>
                        <small id="error-file_level" class="error-text form-text text-danger"></small>
                        <small class="form-text text-muted">Ensure the file has 'code_level' in Column A and 'name_level' in Column B, starting from row 2.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </div>
    </div>
</form>
