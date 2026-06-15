<div>

    <div class="card row mt-2 col-md-12">
        <div class="card-header">
            <h3 class="card-title">Purchase Request</h3>
            <div class="card-tools">
                <h5 style="text-align:right;color:green;">
                    Total Amount: {{number_format($DocTotal,2)}}
                </h5>
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
            <form method="POST" wire:submit="createTransaction">
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
                    <input wire:model.blur="UserCode" type="text" readonly placeholder="User Code"
                        class="form-control" />
                    @error('requester') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for>Requester Name</label>
                    <input wire:model.blur="ReqName" readonly placeholder="Requester Name" class="form-control"
                        style="font-weight:bold" />
                    @error('ReqName') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for>Required Date</label>
                    <input wire:model.live="DocDate" type="text" class="form-control" autocomplete="off"
                        placeholder="Required Date" id="datepicker">
                    @error('DocDate') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>



        </div>

        <div class="form-row">


            <div class="form-group col-md-6">
                <label for>Remarks/Comments</label>
                <input wire:model.blur="Comments" placeholder="" class="form-control" />
                @error('Comments') <span class="text-danger">*{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-3">
                <label for>Personel Name</label>
                <input wire:model.blur="CardName" placeholder="" class="form-control" />
                @error('CardName') <span class="text-danger">*{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-md-3">
                <label for>Phone Number</label>
                <input wire:model.blur="Address" placeholder="" class="form-control" />
                @error('Address') <span class="text-danger">*{{ $message }}</span> @enderror
            </div>



        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for>Attachments</label>

                <input type="file" wire:model.live="newattachment" class="form-control" multiple>
                <div wire:loading wire:target="attachments">Uploading...</div>
                @error('attachments') <span class="text-danger">*{{ $message }}</span> @enderror
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
                                {{ $data->getClientOriginalName() }}
                            </td>
                            <td>
                                <a href="#">
                                    <i class="fa fa-trash red"
                                        wire:click="removeAttachment({{$index}})"></i></a>
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
                    <th style="width: 10%">Amount</th>
                    <th style="width: 10%">Project</th>
                    <th style="width: 10%">Product Line</th>
                    <th style="width: 10%">Department</th>
                    <th style="width: 10%">Location</th>
                    <th style="width: 10%">Sub Contractor</th>
                    <th style="width: 10%">Vehicles</th>
                    <th style="width: 2%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requestLines as $index => $line)
                <tr wire:key="{{ $index }}">
                    <td style="width: 15%">
                        <select wire:model.live="requestLines.{{$index}}.AcctCode"
                            name="requestLines[{{$index}}][AcctCode]" class="form-control">
                            <option value="">....</option>
                            @foreach ($expenses as $val)
                            <option value="{{$val->AcctCode}}">{{$val->AcctName}}</option>
                            @endforeach
                        </select>
                        @error('requestLines.'.$index.'.AcctCode')
                         <span class="text-danger">*{{ $message
                                        }}</span> @enderror
                    </td>

                    <td style="width: 15%">
                        <input name="requestLines[{{$index}}][ItemDescriptionInfo]" type="text"
                            class="form-control"
                            wire:model.live="requestLines.{{$index}}.ItemDescriptionInfo" />

                    </td>
                    <td style="width: 5%">
                        <input name="requestLines[{{$index}}][amount]" type="text" class="form-control"
                            wire:model.live="requestLines.{{$index}}.amount" />
                        @error('requestLines.'.$index.'.amount') <span class="text-danger">*{{ $message
                                        }}</span> @enderror
                    </td>

                    <td style="width: 10%">

                        <select wire:model.live="requestLines.{{$index}}.Project"
                            wire:click.live="$set('project-changed')"
                            name="requestLines[{{$index}}][OcrCode]" class="form-control">
                            <option value="">....</option>
                            @foreach ($projects as $val)
                            <option value="{{$val->PrcCode}}">{{$val->PrcCode}} - {{$val->PrcName}}</option>
                            @endforeach
                        </select>
                        @error('requestLines.'.$index.'.Project') <span class="text-danger">*{{ $message
                                        }}</span> @enderror
                    </td>

                    <td style="width: 10%">

                        <select wire:model.live="requestLines.{{$index}}.OcrCode"
                            name="requestLines[{{$index}}][OcrCode]" class="form-control">
                            <option value="">....</option>
                            @foreach ($productLines as $val)
                            <option value="{{$val->PrcCode}}">{{$val->PrcCode}} - {{$val->PrcName}}</option>
                            @endforeach
                        </select>
                        @error('requestLines.'.$index.'.OcrCode') <span class="text-danger">*{{ $message
                                        }}</span> @enderror
                    </td>
                    <td style="width: 10%">

                        <select wire:model.live="requestLines.{{$index}}.OcrCode2"
                            name="requestLines[{{$index}}][OcrCode2]" class="form-control">
                            <option value="">....</option>
                            @foreach ($departments as $val)
                            <option value="{{$val->PrcCode}}">{{$val->PrcCode}} - {{$val->PrcName}}</option>
                            @endforeach
                        </select>
                        @error('requestLines.'.$index.'.OcrCode2') <span class="text-danger">*{{ $message
                                        }}</span> @enderror
                    </td>
                    <td style="width: 10%">

                        <select wire:model.live="requestLines.{{$index}}.OcrCode3"
                            name="requestLines[{{$index}}][OcrCode3]" class="form-control">
                            <option value="">....</option>
                            @foreach ($locations as $val)
                            <option value="{{$val->PrcCode}}">{{$val->PrcCode}} - {{$val->PrcName}}</option>
                            @endforeach
                        </select>
                        @error('requestLines.'.$index.'.OcrCode3') <span class="text-danger">*{{ $message
                                        }}</span> @enderror
                    </td>
                    <td style="width: 10%;text-align:center">

                        @if ($requestLines[$index]["OcrCode4"])
                        {{$requestLines[$index]["OcrCode4"]}}

                        <a href="#" wire:click.click="removeContractor({{$index}})" wire:key="item-{{$index }}">
                            <i class="fa fa-edit cyan"></i></a>
                        @else
                        <select wire:model.live="requestLines.{{$index}}.OcrCode4"
                            name="requestLines[{{$index}}][OcrCode3]" class="form-control">
                            <option value="">....</option>
                            @foreach ($subcontractors as $val)
                            <option value="{{$val->PrcCode}}">{{$val->PrcCode}} - {{$val->PrcName}}</option>
                            @endforeach
                        </select>

                        @endif
                        @error('requestLines.'.$index.'.OcrCode4') <span class="text-danger">*{{ $message
                                        }}</span> @enderror
                    </td>

                    <td style="width: 10%;text-align:center">

                        @if ($requestLines[$index]["OcrCode5"])
                        {{$requestLines[$index]["OcrCode5"]}}

                        <a href="#" wire:click.click="removeVehicle({{$index}})" wire:key="item-{{$index }}">
                            <i class="fa fa-edit cyan"></i></a>
                        @else
                        <select wire:model.blur="requestLines.{{$index}}.OcrCode5"
                            name="requestLines[{{$index}}][OcrCode3]" class="form-control">
                            <option value="-1">....</option>
                            @foreach ($vehicles as $val)
                            <option wire:key="{{ $val->id}}" value="{{ $val->PrcCode }}">{{$val->PrcCode}} -
                                {{$val->PrcName}}
                            </option>
                            @endforeach
                        </select>
                        @endif


                        @error('requestLines.'.$index.'.OcrCode5') <span class="text-danger">*{{ $message
                                        }}</span> @enderror
                    </td>



                    <td style="width: 2%; text-align:center">

                        <a href="#">
                            <i class="fa fa-trash red" wire:click="removeLine({{$index}})"></i></a>

                    </td>
                </tr>

                @endforeach
                @error('requestLines') <span class="text-danger">*{{ $message }}</span> @enderror
            </tbody>
        </table>
        <a href="#" class="btn btn-success btn-sm mt-1 ml-2 " wire:click.click="addRow()">
            Add Row
        </a>
    </div>


    <div class="modal-footer">

        <div wire:loading wire:target="createTransaction">
            Submitting Request.......
        </div>
        <button v-show="editmode" type="submit" wire:loading.remove wire:target="createTransaction"
            class="btn btn-primary">
            Save
        </button>
    </div>
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

                                <td>{{ $data->getClientOriginalName() }}</td>
                                <td>

                                    <a href="#">
                                        <i class="fa fa-trash red"
                                            wire:click="removeAttachment({{$index}})"></i></a>

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