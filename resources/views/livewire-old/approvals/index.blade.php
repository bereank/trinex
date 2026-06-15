<div>


    <div class="card row mt-2">

        <div class="card-header">
            <h6 class="card-title">{{$database->dbdetails->db_name}}</h6>
            <div class="card-tools">
               
             
              
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
            {{-- <div class="m-1">
                <input type="text" wire:model.live="search" autocomplete="off" placeholder="Search Students" class="form-control col-md-4" />
            </div> --}}
            <table class="table table-bordered table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                
                        <th>Type</th>
                        <th>Doc Num</th>
                        <th>Originator</th>
                        <th>BP Code</th>
                        <th>BP Name</th>
                        <th>Doc Total(LC)</th>
                        <th>Draft Entry</th>
 
                        <th>Date</th>
                        <th>Remarks</th>
    
                        <th></th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($database->approvalrequests as $data)
                    <tr  class="{{$data->approvalLogData  ? "bg-warning" : "bg-white"}}" >

                    
                        <td>{{$data->doctype}}</td>
                        <td>
                            <a href="#" wire:click.click="showApprovalStatus({{$data->WddCode}})">
                                {{ $data->draftDocument['DocNum']}}
                            </a>
                        </td>
                        <td>{{$data->documentowner?->name}}</td>
                        <td>{{ $data->draftDocument['CardCode']  ?? "N/A"}}</td>
                        <td>{{ $data->draftDocument['CardName']  ?? "N/A"}}</td>
                  
                        <td class="text-right" style="font-weight:bold" > {{$data->draftDocument['DocCur'] ?? ""}}   {{$data->draftDocument  ?  number_format($data->draftDocument['DocTotal'],2) :"N/A"}}</td>
                        <td>{{$data->DraftEntry}}</td>
                            
                        <td>{{$data->CreateDate ." " .$data->CreateTime }}</td>
                        <td>{{$data->draftDocument['Comments'] ?? $data->Remarks}}</td>
                        <td>

                            @if($data->approvalLogData )
                                
                            <a href="#" wire:click.click="showSyncError({{$data->approvalLogData }})">
                                <i class="fa fa-eye red"></i></a>
                            @endif

                            @if(!$data->approvalLogData )
                            <a href="{{ route('approvalrequest.document.draft', ['client_id' =>$clientID ,'ObjType' =>$data->ObjType,'WddCode' =>$data->WddCode,'draftEntry' =>$data->DraftEntry]) }}">
                                <i class="fa fa-edit blue">View</i></a>
                            @endif

                        </td>
                    </tr>
                    @endforeach


                    
                    {{-- FOR REQUEST FROM EXPRESS WAY --}}
                    @foreach ($expressWayApprovalRequest as $data)
                    <tr>
    
                        <td>Purchase Request</td>
                     
                        <td>
                            <a href="#" wire:click.click="showApprovalStatus2({{$data->id}})">
                          
                                    {{$data->id}}
                              
                            </a>
                        
                        </td>
               
                        <td>{{$data->createdby->name}}</td>
                        <td></td>
                        <td></td>
                        <td>{{$data->DocTotal}}</td>
                        <td></td>
                        <td>{{$data->created_at}}</td>
                        <td>{{$data->Comments}}</td>

                        <td>
                            <a href="{{ route('expense.view', ['client_id' => $data->client_id,'expense_id' => $data->id]) }}">
                                <i class="fa fa-edit blue">View</i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $database->approvalrequests->links() }}
        </div>
       
    </div>
    <hr>
 
   


    <div>
        <div class="modal fade @if($show === true) show @endif"  style="display: @if($show === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" >Approvel Decision Report</h5>
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
                                    <tr>
                                        <td>{{$data['WddCode']}}</td>
                                        <td>{{$data->approverdata?->name}}</td>
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
        <div class="modal fade @if($showError === true) show @endif"  style="display: @if($showError === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content " >
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="exampleModalLabel" >Sync Error</h5>
                        <button class="close" type="button" aria-label="Close" wire:click.prevent="doClose()">
                            <span aria-hidden="true"> Close</span>
                        </button>
                    </div>

                        <div class="modal-body">
                         
                            <p> {{$SyncError}}</p>
                       

                        </div>
                  
                  
                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show" id="backdrop" style="display: @if($showError === true)
                 block
         @else
                 none
         @endif;"></div>
    </div>


    <div>
        <div class="modal fade @if($show2 === true) show @endif" style="display: @if($show2 === true)
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
                                @foreach ($approvaldecisionreport2 as $data)
                                <tr>
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

        <div class="modal-backdrop fade show" id="backdrop" style="display: @if($show2 === true)
                 block
         @else
                 none
         @endif;"></div>
    </div>


</div>
