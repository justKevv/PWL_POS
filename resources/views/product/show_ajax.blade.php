@empty($product)
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
                <a href="{{ url('/item') }}" class="btn btn-warning">Return</a>
            </div>
        </div>
    </div>
@else
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Product Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right col-3">ID :</th>
                    <td class="col-9">{{ $product->id_product }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Product Code :</th>
                    <td class="col-9">{{ $product->product_code }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Product Name :</th>
                    <td class="col-9">{{ $product->product_name }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Category :</th>
                    <td class="col-9">{{ $product->category->name_category }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Purchase Price :</th>
                    <td class="col-9">{{ $product->purchase_price }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Selling Price :</th>
                    <td class="col-9">{{ $product->selling_price }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary">Return</button>
        </div>
    </div>
</div>
@endempty
