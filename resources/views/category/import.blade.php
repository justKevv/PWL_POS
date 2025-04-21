<form action="{{ url('/category/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Categories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="file_category">Select Excel File (.xlsx, .xls)</label>
                    <input type="file" class="form-control-file" id="file_category" name="file_category" accept=".xlsx, .xls" required>
                    <small id="error-file_category" class="error-text form-text text-danger"></small>
                </div>
                <small class="form-text text-muted">
                    Ensure the Excel file has the following columns in order:
                    <ul>
                        <li>Column A: Category Code</li>
                        <li>Column B: Category Name</li>
                    </ul>
                    The first row should be headers and will be skipped.
                </small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Import Data</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#form-import').submit(function(e) {
            e.preventDefault();

            $('.error-text').text('');

            var formData = new FormData(this);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });
                        dataCategory.ajax.reload();
                    } else {
                        // Display validation errors
                        if (response.msgField) {
                            $.each(response.msgField, function(key, value) {
                                $('#error-' + key).text(value[0]);
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

        });
    });
</script>
