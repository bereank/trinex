<div>
    <div class="card row mt-2">
        <div class="card-header">
            <h3 class="card-title">Approval Request : <b>{{$approvalRequestObject->doctype}}</b> </h3>
            <div class="card-tools">

        

                <a href="#" class="btn btn-primary btn-sm" wire:click.prevent="doFormSettingShow()">
                    Form Settings
                </a>

                <a href="#" class="btn btn-success btn-sm" wire:click.prevent="doShow()">

                    Approve
                </a>

                <a href="#" class="btn btn-danger btn-sm" wire:click.prevent="doShowRejectionModal()">

                    Reject
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">



            <form>
                <div class="modal-body">

                    <div class="form-row">

                        @foreach ($headerFields as $field)
                        @isset($documentObject[$field['Column']])
                        <div class="form-group col-md-{{$field['Size']}}">
                        

                          
                            <label for>{{$field['Label']}}</label>
                            <input value="{{ $field['Type'] == 1 ? number_format( $documentObject[$field['Column']],2) : $documentObject[$field['Column']]}}" readonly type="text" placeholder="DocumentType"

                          class="form-control" />

                               
                        </div>
                        @endisset
                        @endforeach
      
                    </div>


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
                                                href="{{ route('approvalrequest.attachment', ['client_id' =>$client_id,'ObjType' =>$this->ObjType,'draftEntry' =>$DraftEntry,'LineAttach' => $data['Line']]) }} ">
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

                    <table class="table table-bordered table-hover table-sm">


                        <thead class="thead-light">
                            <tr>
                                <td colspan="14">
                                    <h3 class="card-title"><b>Item List</b> </h3>
                                </td>
                            </tr>
                            <tr>

                                @foreach ($rowFields  as $field)
                               <th>{{$field['Label']}}</th> 
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documentRows as $data)
                            <tr>
                         
                                @foreach ($rowFields  as $field)

                                @if(isset($data[$field['Column']]))
                                <td style="font-weight:bold">{{ $field['Type'] == 1 ? number_format($data[$field['Column']],2) : $data[$field['Column']]}}</td>
                                @else
                                <td>N/A</td>
                                @endif
                               
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </form>


            <hr>


        

          
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
                            <span aria-hidden="true"> Close</span>
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



    
    <div>
        <div class="modal fade @if($showFormSettings=== true) show @endif"  style="display: @if($showFormSettings === true)
                 block
         @else
                 none
         @endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" >Form Settings</h5>
                        <button class="close" type="button" aria-label="Close" wire:click.prevent="doClose()">
                            <span aria-hidden="true"> Close</span>
                        </button>
                    </div>

                    <div class="m-1">
                   
                
                        <div class="form-check form-check-inline">
                  
                            <input class="form-check-input" type="radio" id="inlineCheckbox1" wire:model.live="Position" value="0">
                            <label class="form-check-label" for="inlineCheckbox1">Header Fields</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox2" wire:model.live="Position" value="1">
                            <label class="form-check-label" for="inlineCheckbox2">Table Fields</label>
                        </div>
                    
                <hr>
                
                    </div>

                        <div class="modal-body">
                         
                            <table class="table table-bordered table-hover table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Label</th>
                                        <th>Visible</th>
                                        <th>Sort</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($formSettings as $formSetting)
                                    <tr>
                                        <td>{{$formSetting->Label}}</td>
                                        <td>

                                            @if ($formSetting->Visible ==1)
                                            <a href="#" wire:click="changeVisibilty({{$formSetting->id}})">
                                                <span class="badge badge-warning rounded-pill d-inline">
                                                    Disable
                                                </span>
                                            </a>
                                            @endif
                                            @if ($formSetting->Visible ==0)
                                            <a href="#" wire:click="changeVisibilty({{$formSetting->id}})">
                                                <span class="badge badge-success rounded-pill d-inline">
                                                    Enable
                                                </span>
                                            </a>
                                            @endif
                                            
                                      
                                        <td>
                                          
                                            @if(!$loop->first)
                                            <a href="#" wire:click="changeVisibiltyOrderUp({{$formSetting->id}})">

                                                <span class="badge badge-primary rounded-pill d-inline">
                                                Move Up
                                                </span>
                                            </a>
                                    
                                                
                                            @endif
                                           
                                            <span></span>
                                       
                                            @if(!$loop->last)
                                            <a href="#" wire:click="changeVisibiltyOrderDown({{$formSetting->id}})">
                                                <span class="badge badge-success rounded-pill d-inline">
                                                   Move Down
                                                </span>
                                            </a>
                            
                                            @endif
                                           
                                    
                                            
                                        </td>
                                       
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                  
                  
                </div>
            </div>
        </div>

        <div class="modal-backdrop fade show" id="backdrop" style="display: @if($showFormSettings === true)
                 block
         @else
                 none
         @endif;"></div>
    </div>

    
</div>