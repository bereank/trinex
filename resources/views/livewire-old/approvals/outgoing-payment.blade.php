<div>
    <div class="card row mt-2">
        <div class="card-header">
            <h3 class="card-title">Approval Request : <b>{{$approvalRequestObject->doctype}}</b> </h3>
            <div class="card-tools">

                <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">

                    Back
                </a>
                <a href="#" class="btn btn-success" wire:click.prevent="doShow()">

                    Approve
                </a>

                <a href="#" class="btn btn-danger" wire:click.prevent="doShowRejectionModal()">

                    Reject
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">



            <form>
                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-md-2">
                            <label for>Document Type</label>
                            <input value="Outgoing Payment" readonly type="text" placeholder="DocumentType"
                                class="form-control" />

                        </div>
                        <div class="form-group col-md-2">
                            <label for>Draft Document</label>
                            <input value="{{$documentObject['DocNum']}}" readonly type="text" placeholder="DocNum"
                                class="form-control" style="font-weight:bold" />

                        </div>
                        <div class="form-group col-md-2">
                            <label for>Created By</label>
                            <input wire:model.blur="CreatedBy" readonly type="text" placeholder="CreatedBy"
                                class="form-control" style="font-weight:bold" />

                        </div>

                        <div class="form-group col-md-2">
                            <label for>Document Owner</label>
                            <input wire:model.blur="CreatedBy" readonly type="text" placeholder="Document Owner"
                                class="form-control" style="font-weight:bold" />

                        </div>
                        <div class="form-group col-md-2">
                            <label for>Date</label>
                            <input value="{{$documentObject['DocDate']}}" readonly type="text" placeholder="Date"
                                class="form-control" style="font-weight:bold" />

                        </div>

                        <div class="form-group col-md-2">
                            <label for>Doc Total</label>
                            <input value="{{number_format($documentObject['DocTotal'],2)}}" readonly type="text"
                                placeholder="Doc Total" class="form-control" style="font-weight:bold" />

                        </div>

                        {{-- <div class="form-group col-md-2">
                            <label for>Doc Total FC </label>
                            <input
                                value="{{$documentObject['DocCurr'] ." ".number_format($documentObject['DocTotalFC'], 2)}}"
                                readonly type="text" class="form-control" style="font-weight:bold" />

                        </div> --}}

                        <div class="form-group col-md-2">
                            <label for>Doc Rate </label>
                            <input value="{{number_format($documentObject['DocRate'], 2)}}" readonly type="text"
                                class="form-control" style="font-weight:bold" />

                        </div>
                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for>Business Partner Name</label>
                            <input value="{{$documentObject['CardName']}}" readonly type="text"
                                placeholder="Customer Name" class="form-control" />

                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for>Cash Account</label>
                            <input value="{{$documentObject['CashAcct']}}" readonly type="text"
                                placeholder="Cash Account" class="form-control" style="font-weight:bold" />

                        </div>
                        <div class="form-group col-md-2">
                            <label for>Cash Sum</label>
                            <input value="{{number_format($documentObject['CashSum'],2)}}" readonly type="text"
                                placeholder="Cash Sum" class="form-control" style="font-weight:bold" />

                        </div>
                        <div class="form-group col-md-2">
                            <label for>Check Account</label>
                            <input value="{{$documentObject['CheckAcct']}}" readonly type="text"
                                placeholder="Check Account" class="form-control" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for>Check Sum</label>
                            <input value="{{number_format($documentObject['CheckSum'],2)}}" readonly type="text"
                                placeholder="Check Sum" class="form-control" style="font-weight:bold" />
                        </div>

                        <div class="form-group col-md-2">
                            <label for>Transfer Acct</label>
                            <input value="{{$documentObject['TrsfrAcct']}}" readonly type="text"
                                placeholder="Transfer Acct" class="form-control" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for>Transfer Sum</label>
                            <input value="{{number_format($documentObject['TrsfrSum'],2)}}" readonly type="text"
                                placeholder="Transfer Sum" class="form-control" style="font-weight:bold" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for>Transfer Date</label>
                            <input value="{{$documentObject['TrsfrDate']}}" readonly type="text"
                                placeholder="Transfer Date" class="form-control" style="font-weight:bold" />
                        </div>
                        <div class="form-group col-md-2">
                            <label for>Transfer Ref</label>
                            <input value="{{$documentObject['TrsfrRef']}}" readonly type="text"
                                placeholder="Transfer Ref" class="form-control" style="font-weight:bold" />
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for>Requester Remarks</label>
                            <input value="{{$approvalRequestObject->Remarks}}" readonly type="text"
                                placeholder="Remarks" class="form-control" style="font-weight:bold" />

                        </div>

                        <div class="form-group col-md-6">
                            <label for>Journal Remarks</label>
                            <input value="{{$documentObject['JrnlMemo']}}" readonly type="text" placeholder="Remarks"
                                class="form-control" style="font-weight:bold" />

                        </div>

                    </div>



                </div>

            </form>




            @if($hasAttachments)

            <div class="form-row">


                <div class="col-md-8">
                    <table class="table table-bordered table-hover table-sm">


                        <thead class="thead-light">
                            <tr>
                                <td colspan="8">
                                    <h3 class="card-title"><b>Attachments</b> </h3>
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documentAttachments as $data)
                            <tr>
                                <td><b>{{$data['FileName']}}</b></td>
                                <td>
                                    <a target="_blank"
                                        href="{{ route('approvalrequest.attachment', ['client_id' =>$client_id,'ObjType' =>$ObjType,'draftEntry' =>$DraftEntry,'LineAttach' => $data['Line']]) }} ">
                                        <i class="fa fa-edit blue">View</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



            </div>

            @endif

            <hr>

            <div class="form-row mt-2">
                <table class="table table-bordered table-hover table-sm">


                    <thead class="thead-light">
                        <tr>
                            <td colspan="12">
                                <h3 class="card-title"><b>Journal Entry Preview</b> </h3>
                            </td>
                        </tr>
                        <tr>
                            <th>Acct Code</th>
                            <th>Account Name</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Project</th>
                            <th>Location</th>
                            <th>Product Line</th>
                            <th>Department</th>
                            <th>Staff</th>
                            <th>Vehicle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journalEntries as $data)
                        <tr>
                            <td>{{$data['AcctCode']}}</td>
                            <td>{{$data['AcctName']}}</td>
                            <td>{{number_format($data['Debit'],2)}}</td>
                            <td>{{number_format($data['Credit'],2)}}</td>
                            <td>{{$data['ProjectCode'] ?? "N/A" }}</td>
                            <td>{{$data['Location']}}</td>
                            <td>{{$data['ProductLine'] ?? "N/A"}}</td>
                            <td>{{$data['Department'] ?? "N/A"}}</td>
                            <td>{{$data['Staff'] ?? "N/A"}}</td>
                            <td>{{$data['Vehicle'] ?? "N/A"}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>


    <div>
        <div class="modal fade @if($show === true) show @endif" id="myExampleModal" style="display: @if($show === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:green">
                        <h5 class="modal-title" id="exampleModalLabel">Approvel Request Decision</h5>
                        <button class="close" type="button" aria-label="Close" wire:click.prevent="doClose()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>


                    <form wire:submit="approveOrRejectDocoment('Y')">
                        <div class="modal-body">
                            <div class="form-group" v-show="!editmode">
                                <label for="">Remarks</label>

                                <textarea rows="3" wire:model.blur="remarks" placeholder="Approval Remarks"
                                    class="form-control"></textarea>
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

        <div class="modal-backdrop fade show" id="backdrop" style="display: @if($show === true)
                 block
         @else
                 none
         @endif;"></div>
    </div>


    <div>
        <div class="modal fade @if($show1 === true) show @endif" id="myExampleModal1" style="display: @if($show1 === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header" style="background-color:red">
                        <h5 class="modal-title" id="exampleModalLabel">Reject Request Decision</h5>
                        <button class="close" type="button" aria-label="Close" wire:click.prevent="doClose()">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form wire:submit="approveOrRejectDocoment('N')">
                        <div class="modal-body">
                            <div class="form-group" v-show="!editmode">
                                <label for="">Remarks</label>

                                <textarea rows="3" wire:model.blur="remarks" placeholder="Rejection Remarks"
                                    class="form-control"></textarea>
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


    <div wire:loading wire:target="approveDocument">
        Processing Payment...
    </div>



</div>