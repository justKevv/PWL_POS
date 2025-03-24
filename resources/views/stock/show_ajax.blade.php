@empty($stock)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="fa-ban fa-ban icon"></i> Error!</h5>
                    Data not found
                </div>
                <a href="{{ url('/stock') }}" class="btn btn-warning">Return</a>
            </div>
        </div>
    </div>
@else
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Stock Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right col-3">ID :</th>
                    <td class="col-9">{{ $stock->id_stock }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Product :</th>
                    <td class="col-9">{{ $stock->product->product_name }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">User :</th>
                    <td class="col-9">{{ $stock->user->username }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Date :</th>
                    <td class="col-9">{{ $stock->date_stock }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Quantity :</th>
                    <td class="col-9">{{ $stock->stock_quantity }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary">Return</button>
        </div>
    </div>
</div>
@endempty