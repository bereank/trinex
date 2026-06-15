<div>

    <div class="card row mt-2">
        <div class="card-header">
            <h3 class="card-title">Purchase Request</h3>
            <div class="card-tools">

                <a href="{{ route('expense.new',['client_id' => $client_id]) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i>
                    New
                </a>
            </div>
        </div>
        @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!</strong> {{session('message')}}.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        @endif

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">

            <table class="table table-bordered table-hover table-sm">
                <thead class="thead-light">
                    <tr>

                
                        <th>Requester</th>
                        <th>Total</th>
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
                        <td>{{$data->created_at}}</td>
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

                            @if ($data->ExtRef)
                            <a href="#">
                                <span class="badge badge-success rounded-pill d-inline">
                                    Sync Successfully
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
                            <a href="{{ route('expense.view', ['client_id' => $data->client_id,'expense_id' => $data->id]) }}">
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
                                <tr class="{{$data->Status =='N'  ? "bg-danger" : "bg-white"}}">
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
                        <button v-show="editmode" type="submit" class="btn btn-success" wire:click="intiateDocumentSync()">
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
</div>
