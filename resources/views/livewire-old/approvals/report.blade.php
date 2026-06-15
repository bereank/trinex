<div>


    <div class="card row mt-2">

        <div class="card-header">
            <h6 class="card-title">Approval Reports</h6>

        </div>
        @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!</strong> {{session('message')}}.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        @endif

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">



            <div class="modal-body">
        
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for>From</label>
                        <input wire:model.live="fromDocDate" type="text" class="form-control" autocomplete="off"
                            placeholder="Create Date" id="datepicker">
                        @error('fromDocDate') <span class="text-danger">*{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for>From To</label>
                        <input wire:model.live="toDocDate" type="text" class="form-control" autocomplete="off"
                            placeholder="Create Date" id="datepickerTo">
                        @error('toDocDate') <span class="text-danger">*{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for>Created By</label>
                        <select wire:model.live="UserSign" id="type" class="form-control">
                            <option value="select">Select</option>



                            @foreach ($created_users  as $val)
                            <option value="{{$val->id}}">{{$val->name}}</option>
                            @endforeach
                        
                        </select>
                        @error('collection_mode') <span class="text-danger">*{{ $message }}</span> @enderror
                    </div>

                </div>
           
            </div>

            <table class="table table-bordered table-hover table-sm">
                <thead class="thead-light">
                    <tr>


                        <th>Doc Num</th>
                        <th>Originator</th>

                        <th>Doc Total(LC)</th>


                        <th>Date</th>
                        <th>Remarks</th>

                        <th></th>


                    </tr>
                </thead>
                <tbody>



                    {{-- FOR REQUEST FROM EXPRESS WAY --}}
                    @foreach ($expressWayApprovalRequest as $data)
                    <tr>



                        <td>
                            <a href="#" wire:click.click="showApprovalStatus2({{$data->id}})">

                                {{$data->id}}

                            </a>

                        </td>

                        <td>{{$data->createdby->name}}</td>

                        <td>{{$data->DocTotal}}</td>

                        <td>{{$data->created_at}}</td>
                        <td>{{$data->Comments}}</td>

                        <td>
                            <a
                                href="{{ route('expense.view', ['client_id' => $data->client_id,'expense_id' => $data->id]) }}">
                                <i class="fa fa-edit blue">View</i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $expressWayApprovalRequest->links() }}
        </div>

    </div>
    <hr>




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
        <div class="modal fade @if($showError === true) show @endif" style="display: @if($showError === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" id="exampleModalLabel">Sync Error</h5>
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

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvaldecisionreport2 as $data)
                                <tr class="{{$data->Status =='Y'  ? " bg-success" : "bg-white" }}">
                                    <td>{{$data->approvalstage?->Name}}</td>
                                    <td>{{$data->authorizer?->name}}</td>
                                    <td>{{$data['StatusNormal']}}</td>
                                    <td>{{$data['Remarks']}}</td>
                                    <td>{{$data['UpdateDate']}}</td>

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