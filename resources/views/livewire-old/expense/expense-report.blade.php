<div>

    <div class="card row mt-2">
        <div class="card-header">
            <h3 class="card-title">Purchase Request Reports</h3>
            <div class="card-tools">
                <h5 style="text-align:right;color:green;display:inline-block;margin-right:10px;">
                    Total Documents: {{$totalRaised}}
                </h5>
                <a href="{{ route('expense.report.export', [
                    'client_id' => $client_id,
                    'UserSign' => $UserSign,
                    'fromDocDate' => $fromDocDate,
                    'toDocDate' => $toDocDate,
                    'WddStatus' => $WddStatus,
                    'PaidToDate' => $PaidToDate,
                    'OcrCode3' => $OcrCode3
                ]) }}"
                    class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i>
                </a>
            </div>
        </div>


        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <div class="modal-body">

                <div class="form-row">

                    <div class="form-group col-md-2">
                        <label for>Created By</label>
                        <select wire:model.live="UserSign" id="type" class="form-control">
                            <option value="select">Select</option>



                            @foreach ($created_users as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach

                        </select>
                        @error('collection_mode') <span class="text-danger">*{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for>From</label>
                        <input wire:model.live="fromDocDate" type="text" class="form-control" autocomplete="off"
                            placeholder="Create Date" id="datepicker">
                        @error('fromDocDate') <span class="text-danger">*{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for>From To</label>
                        <input wire:model.live="toDocDate" type="text" class="form-control" autocomplete="off"
                            placeholder="Create Date" id="datepickerTo">
                        @error('toDocDate') <span class="text-danger">*{{ $message }}</span> @enderror
                    </div>


                    <div class="form-group col-md-2">
                        <label for>Approval Status</label>
                        <select wire:model.live="WddStatus" id="type" class="form-control">
                            <option value="-1">All</option>
                            <option value="Y">Approved</option>
                            <option value="W">Pending Approval</option>


                        </select>
                        @error('WddStatus') <span class="text-danger">*{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label for>Payment Status</label>
                        <select wire:model.live="PaidToDate" id="type" class="form-control">
                            <option value="-1">All</option>
                            <option value="1">Paid</option>
                            <option value="0">Pending</option>


                        </select>
                        @error('PaidToDate') <span class="text-danger">*{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for>Truck</label>
                        <select wire:model.live="OcrCode3" id="type" class="form-control">
                            <option value="-1">All</option>
                            @foreach ($vehicles as $val)
                            <option wire:key="{{ $val->id}}" value="{{ $val->PrcCode }}">{{$val->PrcCode}} -
                                {{$val->PrcName}}
                            </option>
                            @endforeach
                        </select>
                        @error('OcrCode3') <span class="text-danger">*{{ $message }}</span> @enderror
                    </div>

                </div>

            </div>
            <table class="table table-bordered table-hover table-sm">
                <thead class="thead-light">
                    <tr>


                        <th>Requester</th>
                        <th>Total</th>
                        <th>Paid Total</th>
                        <th>Date</th>
                        <th>Remarks</th>
                        <th>SAP Doc #</th>
                        <th>Status</th>
                        <th></th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($documnets as $data)
                    <tr>


                        <td>{{$data->ReqName}}</td>
                        <td>{{number_format($data->DocTotal,2)}}</td>
                        <td>{{number_format($data->PaidToDate,2)}}</td>
                        <td>{{$data->DocDate}}</td>
                        <td>{{$data->Comments}}</td>
                        <td>{{$data->ExtRefDocNum}}</td>
                        <td>



                            @if ($data->CANCELED == 'N' && $data->WddStatus != 'N')


                            @if ($data->WddStatus == 'Y')
                            <a href="#" wire:click.click="showApprovalStatus({{$data->id}})">
                                <span class="badge badge-success rounded-pill d-inline">
                                    Approved
                                </span>
                            </a>
                            @endif


                            @if ($data->WddStatus == 'N')
                            <a href="#" wire:click.click="showApprovalStatus({{$data->id}})">
                                <span class="badge badge-danger rounded-pill d-inline">
                                    Document Rejected
                                </span>
                            </a>
                            @endif


                            @if ($data->WddStatus == 'W')
                            <a href="#" wire:click.click="showApprovalStatus({{$data->id}})">
                                <span class="badge badge-warning rounded-pill d-inline">
                                    Pending Approval
                                </span>
                            </a>
                            @endif




                            @if (!$data->ExtRef)
                            <a href="#">
                                @if (!$data->ExtRef && $data->EDocStatus == 0)
                                <a href="#" wire:click="showErrorStatus({{$data->id}})">
                                    <span class="badge badge-warning rounded-pill d-inline">
                                        Pending Sync
                                    </span>
                                </a>
                                @endif
                                @if (!$data->ExtRef && $data->EDocStatus == 1)
                                <a href="#" wire:click="showErrorStatus({{$data->id}})">
                                    <span class="badge badge-danger rounded-pill d-inline">
                                        Error Syncing
                                    </span>
                                </a>
                                @endif
                            </a>
                            @endif


                            @endif

                            @if ($data->CANCELED == 'Y')
                            <a href="#" wire:click="showErrorStatus({{$data->id}})">
                                <span class="badge badge-danger rounded-pill d-inline">
                                    Document Cancelled
                                </span>
                            </a>
                            @endif




                            @if ($data->WddStatus == 'N')
                            <a href="#" wire:click.click="showApprovalStatus({{$data->id}})">
                                <span class="badge badge-danger rounded-pill d-inline">
                                    Document Rejected
                                </span>
                            </a>
                            @endif



                        </td>
                        <td>
                            <a
                                href="{{ route('expense.view', ['client_id' => $data->client_id,'expense_id' => $data->id]) }}">
                                <i class="fa fa-eye cyan"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $documnets->links() }}
        </div>
    </div>

    <div>
        <div class="modal fade @if($show === true) show @endif" style="display: @if($show === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approvel Decision Report</h5>
                        <button class="close" type="button" aria-label="Close" wire:click.prevent="doClose()">
                            <span aria-hidden="true"> Close</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Stage</th>
                                    <th>Authorizer</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Update Date</th>
                                    <th>Update Time</th>



                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvaldecisionreport as $data)
                                <tr class="{{$data->Status =='N'  ? " bg-danger" : "bg-white" }}">
                                    <td>{{$data->approvalstage?->Name}}</td>
                                    <td>{{$data->authorizer?->name}}</td>
                                    <td>{{$data['StatusNormal']}}</td>
                                    <td>{{$data['Remarks']}}</td>
                                    <td>{{$data['UpdateDate']}}</td>
                                    <td>{{$data['UpdateTime']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>


                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show" id="backdrop" style="display: @if($show === true)
                 block
         @else
                 none
         @endif;"></div>
    </div>



    <div>
        <div class="modal fade @if($showSyncStatus === true) show @endif" style="display: @if($showSyncStatus === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sync Error</h5>
                        <button class="close" type="button" aria-label="Close" wire:click.prevent="doClose()">
                            <span aria-hidden="true"> Close</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        {{$errorSyncing}}

                    </div>

                    <div class="modal-footer">

                        <div wire:loading wire:target="intiateDocumentSync">
                            Submitting Request.......
                        </div>
                        <button v-show="editmode" type="submit" class="btn btn-success"
                            wire:click="intiateDocumentSync()">
                            INITIATE SYNC
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show" id="backdrop" style="display: @if($showSyncStatus=== true)
                 block
         @else
                 none
         @endif;"></div>
    </div>

    <script type="text/javascript">
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd', // Set the desired date format
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function(e){
            @this.set('fromDocDate', e.format());
        });
    </script>

    <script type="text/javascript">
        $('#datepickerTo').datepicker({
        format: 'yyyy-mm-dd', // Set the desired date format
        autoclose: true,
        todayHighlight: true,
    }).on('changeDate', function(e){
        @this.set('toDocDate', e.format());
    });
    </script>
</div>