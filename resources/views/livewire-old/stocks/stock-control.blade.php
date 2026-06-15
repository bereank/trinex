<div>
    <div class="mt-2 mb-2">
        <div class="input-group rounded col-3">
            <input type="text" class="form-control rounded" placeholder="Search" wire:model.live="searchTerm" aria-label="Search" aria-describedby="search-addon" />
        </div> <br>
        <!-- <div class="input-group rounded col-3">
                <select class="form-control rounded" wire:model.live="searchCountryID" name="" id="">
                    <option>--Choose Country--</option>
                    <option value="1">Kenya</option>
                    <option value="1001">Uganda</option>
                    <option value="1002">Tanzania</option>
                </select>
            </div>         -->


        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" wire:model.live="searchCountry" value="1">
            <label class="form-check-label" for="inlineCheckbox1">Kenya</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" wire:model.live="searchCountry" value="1001">
            <label class="form-check-label" for="inlineCheckbox2">Tanzania</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" wire:model.live="searchCountry" value="1002">
            <label class="form-check-label" for="inlineCheckbox3">Uganda</label>
        </div>


    </div>
    <table class="table table-bordered table-hover table-sm">
        <thead class="thead-light">
            <tr>
                <th>S/NO</th>
                <th>Item Code</th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Product Line</th>
                <th>Quantity</a></th>
                <th>Country</th>
                <th>Branch</th>

            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->id }}</td>
                <td>{{ $stock->ItemCode }}</td>
                <td>{{ $stock->stock_head->ItemName }}</td>
                <td>{{ $stock->U_GrpDesc }}</td>
                <td>{{ $stock->U_ProdLine }}</td>
                <td>                    
                    {{ $stock->QtyInstock }}
                </td>
                <td>
                    @if($stock->stock_head->client_id == 1)
                    Kenya
                    @elseif($stock->stock_head->client_id == 1001)
                    Tanzania
                    @elseif($stock->stock_head->client_id == 1002)
                    Uganda
                    @endif
                </td>
                <td>{{ $stock->Branch }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- {{ $stocks->links() }} -->
    {{ $stocks->appends(['searchTerm' => $this->searchTerm])->links() }}

</div>