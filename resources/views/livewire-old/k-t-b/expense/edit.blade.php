<div>

    <div class="card row mt-2 col-md-12">
        <div class="card-header">
            <h3 class="card-title">Purchase Request</h3>

            @if ($syncToSAP)
            <i class="ml-2 alert-danger"><b> SAP Document Number : {{$expenseData->ExtRefDocNum}}</b></i>

            @endif
            <div class="card-tools">
                <h5 style="text-align:right;color:green;">
                    Total Amount: {{number_format($DocTotal,2)}}
                </h5>


                @if ($syncToSAP)



                <a href="{{ route('print.expense',['expenseId' => $expense_id]) }}" target="_blank" class="btn btn-success btn-sm">
                    <i class="fas fa-print"></i>
                    Print
                </a>
                @endif

                @if(count($approvaldecisionreport) > 0)

                <a href="#" class="btn btn-success btn-sm" wire:click.prevent="doApprovalModalShow()">

                    Approve
                </a>

                <a href="#" class="btn btn-danger btn-sm" wire:click.prevent="doShowRejectionModal()">

                    Reject
                </a>

                @endif
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
            <form method="POST" wire:submit="updateTransaction">
                @csrf
                <div class="modal-body">

                    <div class="form-row">
                        {{-- <div class="form-group col-md-2">
                            <label for>Search Staff</label>
                            <input type="text" class="form-control" placeholder="Search Staff..."
                                wire:model.live="query" wire:keydown.escape="reset" wire:keydown.tab="reset"
                                wire:keydown.arrow-up="decrementHighlight" />

                            <div wire:loading wire:target="updatedQuery"
                                class="absolute z-10 w-full bg-white rounded-t-none shadow-lg list-group">
                                <div class="list-item">Searching...</div>
                            </div>

                            @if(!empty($query))


                            <div class="absolute z-10 w-full bg-white rounded-t-none shadow-lg list-group">
                                @if(!empty($contacts))
                                @foreach($contacts as $i => $contact)
                                <h5><a href="#" wire:click="selectedItem({{$contact['id']}})"
                        class="list-group-item {{ $highlightIndex === $i ? 'highlight' : '' }}">{{
                                        $contact['name'] }}</a></h5>
                        @endforeach
                        @else
                        <div class="list-item">No results!</div>
                        @endif
                    </div>
                    @endif
                </div> --}}

                <div class="form-group col-md-4">
                    <label for>User Code</label>
                    <input wire:model.blur="UserCode" type="text" readonly placeholder="User Code" class="form-control" />
                    @error('requester') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for>Requester Name</label>
                    <input wire:model.blur="ReqName" readonly placeholder="Requester Name" class="form-control" style="font-weight:bold" />
                    @error('ReqName') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for>Required Date</label>
                    <input wire:model.live="DocDate" type="text" class="form-control" autocomplete="off" placeholder="Required Date" id="datepicker">
                    @error('DocDate') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>


                <div class="form-group col-md-2">
                    <label for>Document Currency</label>
                    <select wire:model.live="DocCur" class="form-control">
                        <option value="">....</option>

                    </select>
                    @error('DocCur') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for>Country of Visit</label>
                    <input wire:model.blur="covisit" placeholder="country of visit" class="form-control" />
                    @error('covisit') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for>Number of Nights</label>
                    <input wire:model.live="nofnights" type="text" class="form-control" autocomplete="off" placeholder="e.g 2 ">
                    @error('nofnights') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>



        </div>

        <div class="form-row">


            <div class="form-group col-md-8">
                <label for>Remarks/Comments</label>
                <textarea wire:model.blur="Comments" class="form-control" placeholder="area/cluster of visit ,purpose of visit" id="exampleFormControlTextarea1" rows="3"></textarea>
                @error('Comments') <span class="text-danger">*{{ $message }}</span> @enderror
            </div>



        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>File Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attachments as $index => $data)
                        <tr>
                            <td>
                                {{ $data->FileName }}
                            </td>
                            <td>
                                @if (!$syncToSAP && $showAttachmentDeleteButton)

                                <a href="#">
                                    <i class="fa fa-trash red" wire:click="removeAttachment({{$data->id}})">Delete</i></a>

                                @endif


                                <a target="_blank" href="{{ $data->url}} ">
                                    <i class="fa fa-edit blue">View</i></a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



    </div>

    <div class="card-body table-responsive p-0">

        <table class="table table-bordered table-hover table-sm">
            <thead class="thead-light">
                <tr>

                    <th style="width: 15%">Item</th>
                    <th style="width: 15%">Description</th>
                    <th style="width: 10%">Quantity</th>
                    <th style="width: 10%">Unit of Measure</th>
                    <th style="width: 10%">Budget Line</th>
                    <th style="width: 10%">Rate</th>
                    <th style="width: 10%">Amount</th>

                    <th style="width: 5%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestLines as $index => $line)
                <tr wire:key="{{ $index }}">
                    <td style="width: 15%">
                        <select wire:model.live="requestLines.{{$index}}.AcctCode" name="requestLines[{{$index}}][AcctCode]" class="form-control">
                            <option value="">....</option>

                            <option value="1234">Accomodation</option>
                            <option value="5678">Travelling</option>

                        </select>
                        @error('requestLines.'.$index.'.AcctCode') <span class="text-danger">*{{ $message}}</span> @enderror
                    </td>

                    <td style="width: 15%">
                        <input name="requestLines[{{$index}}][ItemDescriptionInfo]" placeholder="event dates" type="text" class="form-control" wire:model.live="requestLines.{{$index}}.ItemDescriptionInfo" />
                        @error('requestLines.'.$index.'.ItemDescriptionInfo') <span class="text-danger">*{{ $message}}</span> @enderror
                    </td>

                    <td style="width: 10%">
                        <input name="requestLines[{{$index}}][quantity]" type="text" class="form-control" wire:model.live="requestLines.{{$index}}.quantity" />
                        @error('requestLines.'.$index.'.quantity') <span class="text-danger">*{{ $message}}</span> @enderror
                    </td>

                    <td style="width: 10%">
                        <input name="requestLines[{{$index}}][uom]" type="text" class="form-control" wire:model.live="requestLines.{{$index}}.uom" />
                        @error('requestLines.'.$index.'.uom') <span class="text-danger">*{{ $message}}</span> @enderror
                    </td>

                    <td style="width: 10%">
                        <select wire:model.live="requestLines.{{$index}}.OcrCode4" name="requestLines[{{$index}}][OcrCode4]" class="form-control">
                            <option value="">....</option>

                            <option value="5432">IT</option>
                            <option value="9876">Sales</option>

                        </select>
                        @error('requestLines.'.$index.'.OcrCode') <span class="text-danger">*{{ $message}}</span> @enderror
                    </td>

                    <td style="width: 5%">
                        <input name="requestLines[{{$index}}][rate]" type="text" class="form-control" wire:model.live="requestLines.{{$index}}.rate" />
                        @error('requestLines.'.$index.'.rate') <span class="text-danger">*{{ $message}}</span> @enderror
                    </td>

                    <td style="width: 10%">
                        <input name="requestLines[{{$index}}][LineTotal]" type="text" class="form-control" wire:model.live="requestLines.{{$index}}.LineTotal" />
                        @error('requestLines.'.$index.'.LineTotal') <span class="text-danger">*{{ $message}}</span> @enderror
                    </td>


                    <td style="width: 2%; text-align:center">

                        <a href="#">
                            <i class="fa fa-trash red" wire:click="removeLine({{$index}})"></i>
                        </a>

                    </td>
                </tr>

                @endforeach
                @error('requestLines') <span class="text-danger">*{{ $message }}</span> @enderror
            </tbody>
        </table>

        @if (!$syncToSAP)
        <a href="#" class="btn btn-success btn-sm mt-1 ml-2 " wire:click.click="addRow()">
            Add Row
        </a>

        @endif
    </div>


    @if (!$syncToSAP)

    <div class="modal-footer">

        <div wire:loading wire:target="updateTransaction">
            Submitting Request.......
        </div>
        <button v-show="editmode" type="submit" wire:loading.remove wire:target="updateTransaction" class="btn btn-primary">
            Save
        </button>
    </div>

    @endif
    </form>

</div>
</div>


<div>
    <div class="modal fade @if($show1 === true) show @endif" id="myExampleModal1" style="display: @if($show1 === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Documents Attachments</h5>
                    <button class="close" type="button" aria-label="Close" wire:click="showAttachments()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for>Import Excel</label>

                            <input type="file" wire:model.live="attachments" class="form-control" multiple>
                            <div wire:loading wire:target="attachments">Uploading...</div>
                        </div>

                    </div>


                    <table class="table table-bordered table-hover table-sm">
                        <thead class="thead-light">
                            <tr>

                                <th>Name</th>
                                <th>Action</th>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attachments as $index => $data)
                            <tr>

                                <td>{{ $data->FileName }}</td>
                                <td>

                                    @if (!$syncToSAP && $showAttachmentDeleteButton)

                                    <a href="#">
                                        <i class="fa fa-trash red" wire:click="removeAttachment({{$data->id}})">Delete</i></a>

                                    @endif


                                    <a target="_blank" href="{{ $data->url}} ">
                                        <i class="fa fa-edit blue">View</i></a>
                                    <a href="#">
                                        <i class="fa fa-trash red" wire:click="removeAttachment({{$index}})"></i></a>

                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <div class="modal-backdrop fade show" id="backdrop" style="display: @if($show1 === true)
                 block
         @else
                 none
         @endif;"></div>
</div>



<div>
    <div class="modal fade @if($showRejectionActionModal === true) show @endif" id="myExampleModal1" style="display: @if($showRejectionActionModal=== true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header" style="background-color:red">
                    <h5 class="modal-title" id="exampleModalLabel">Reject Request Decision</h5>
                    <button class="close" type="button" aria-label="Close" wire:click.prevent="closeAllModals">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form wire:submit="approveOrRejectDocoment('N')">
                    <div class="modal-body">
                        <div class="form-group" v-show="!editmode">
                            <label for="">Remarks</label>

                            <textarea rows="3" wire:model.blur="remarks" placeholder="Rejection Remarks" class="form-control"></textarea>
                            @error('name') <span class=" alert alert-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="modal-footer">

                        <div wire:loading wire:target="rejectDocument">
                            Submitting Request.......
                        </div>
                        <button v-show="editmode" type="submit" class="btn btn-danger">
                            Reject
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal-backdrop fade show" id="backdrop" style="display: @if($show1 === true)
                 block
         @else
                 none
         @endif;"></div>
</div>

<div>
    <div class="modal fade @if($showApprovalActionModal  === true) show @endif" id="myExampleModal" style="display: @if($showApprovalActionModal === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:green">
                    <h5 class="modal-title" id="exampleModalLabel">Approvel Request Decision</h5>
                    <button class="close" type="button" aria-label="Close" wire:click.prevent="closeAllModals">
                        <span aria-hidden="true"> Close</span>
                    </button>
                </div>


                <form wire:submit="approveOrRejectDocoment('Y')">
                    <div class="modal-body">
                        <div class="form-group" v-show="!editmode">
                            <label for="">Remarks</label>

                            <textarea rows="3" wire:model.blur="remarks" placeholder="Approval Remarks" class="form-control"></textarea>
                            @error('name') <span class=" alert alert-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="modal-footer">

                        <div wire:loading wire:target="approveDocument">
                            Submitting Request.......
                        </div>
                        <button v-show="editmode" type="submit" class="btn btn-success">
                            Approve
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal-backdrop fade show" id="backdrop" style="display: @if($showApprovalActionModal === true)
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
    }).on('changeDate', function(e) {
        @this.set('DocDate', e.format());
    });
</script>
</div>