<div>
    <form wire:submit="editUser">
        <div class="modal-body">

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for>Name</label>
                    <input wire:model.blur="name" type="text" readonly placeholder="Full Name" class="form-control" />
                    @error('FName') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for>Email</label>
                    <input wire:model.blur="email" type="email" placeholder="Email" class="form-control" />
                    @error('LName') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for>User Code</label>
                    <input wire:model.blur="ExtUserCode" type="text" readonly placeholder="ExtUserCode" class="form-control" />
                    @error('ExtUserCode') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
   

                <div class="form-group col-md-4">
                    <label for>Role</label>
                    <select wire:model.blur="UserType" id="type" class="form-control">
                        <option value="">Choose Role</option>
                        <option value="0">Normal User</option>
                        <option value="1">Manager</option>
                        <option value="2">Administrator</option>
                    </select>

                </div>

            
                    <div class="form-group col-md-4">
                        <label for>Upload User Signature</label>

                        <input type="file" accept="image/png" wire:model.live="user_signature" class="form-control">


                        @if ($currentSignature)
                     
                        <a target="_blank"
                        href="{{ $currentSignature}} ">
                        <i class="fa fa-edit blue">Current</i></a>
                        @endif
                
                        @error('user_signature') <span class="text-danger">*{{ $message }}</span> @enderror
                    </div>

              
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>


    <div class="modal-body">

        <div class="form-row">
            <div class="form-group col-md-6">
                <div class="m-1">

                    <label for="">User Databases</label>

                </div>
                <table class="table table-bordered table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                     
                            <th>Default Appr. Temp.</th>
                          
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userDatabases as $index=> $data)
                        <tr>



                            <td>{{$data->dbdetails->db_name}}</td>
                          

                            <td>{{$data['defaulttemplate'] ? $data['defaulttemplate']['Name'] : "N/A" }}</td>
                       

                            <td>
                                <a href="#" wire:click="showUserEditModal({{$index}})" class="btn btn-success btn-sm">
                                    Edit
                                </a>
                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



        </div>
    </div>



    
    <div class="modal fade @if($show === true) show @endif" id="myExampleModal" style="display: @if($show === true)
    block
@else
    none
@endif;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Updating User Details {{$companyName }}</h5>
                    <button class="close" type="button" aria-label="Close" wire:click.prevent="doClose()">
                        <span aria-hidden="true"> Close</span>
                    </button>
                </div>


                <form wire:submit="updateUserDetails">
                    <div class="modal-body">

                        <div class="form-group">

                 
                            <label for="">Default Approval Template</label>

                            <select wire:model.live="template_id" class="form-control">
                                <option value="-1">....</option>
                            <option value="-1">No template</option>
                                @foreach ($approvalTemplatesInfo  as $val)
                                <option value="{{$val->id}}">{{$val->Name}}</option>
                                @endforeach

                            </select>
                        </div>

              

                    </div>
                    <div class="modal-footer">

                        <div wire:loading wire:target="updateUserDetails">
                            Submitting Request.......
                        </div>
                        <button v-show="editmode" type="submit" class="btn btn-success">
                           Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
