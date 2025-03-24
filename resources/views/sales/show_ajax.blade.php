@empty($sales)
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
                <a href="{{ url('/sales') }}" class="btn btn-warning">Return</a>
            </div>
        </div>
    </div>
@else
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Sales Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h5>Sales Information</h5>
            <table class="table table-sm table-bordered table-striped mb-4">
                <tr>
                    <th class="text-right col-3">Sales Code :</th>
                    <td class="col-9">{{ $sales->sales_code }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Buyer :</th>
                    <td class="col-9">{{ $sales->buyer }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Date :</th>
                    <td class="col-9">{{ $sales->sales_date }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Staff :</th>
                    <td class="col-9">{{ $sales->user->username }}</td>
                </tr>
            </table>

            <h5>Sales Details</h5>
            <table class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales->detail as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->product->product_name }}</td>
                            <td>{{ $detail->price }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>{{ $detail->subtotal }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <th>{{ $sales->total }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary">Return</button>
        </div>
    </div>
</div>
@endempty