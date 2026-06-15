<div>
    <div class="mt-2">
        <div class="input-group rounded col-3">
            <input type="text" class="form-control rounded" placeholder="Search" wire:model.live="searchTerm" aria-label="Search" aria-describedby="search-addon" />
        </div>
        <div style=" float: right !important; margin-right:50px; margin-bottom: 10px;">
            <a href="{{ route('stock.index') }}" class="btn btn-sm btn-primary">Back</a>
        </div>
    </div>
    <table class="table table-bordered table-hover table-sm">
        <thead class="thead-light">
            <tr>
                <th>Item Code</th>
                <th>Product Name</th>
                <th>Branch</th>
                <th>Quantity</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->ItemCode }}</td>
                <td>{{ $stock->stock_head->ItemName }}</td>
                <td>{{ $stock->U_ProdLine }}</td>
                <td>{{ $stock->Branch }}</td>
                <td>{{ $stock->QtyInstock }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>