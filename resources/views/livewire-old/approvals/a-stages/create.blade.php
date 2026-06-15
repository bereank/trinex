<div>
    <div class="card row mt-2">
        <div class="card-header">
            <h3 class="card-title">Create Approval Stages</h3>
            <div class="card-tools">
                <a href="{{ route('stages.index') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i>
                    Back
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
            <div>
                <form wire:submit="createStage">
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for>Database <i class="text-danger"> *</i></label>
                                <select wire:model.blur="client_id" id="type" class="form-control">
                                    <option value="">Select Database</option>
                                    @foreach ($userDatabases as $val)
                                    <option value="{{$val->client_id}}">{{$val->dbdetails->db_name}}</option>
                                    @endforeach
                                </select>
                                @error('client_id') <span class="text-danger">*{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for>Name</label>
                                <input wire:model.blur="Name" type="text" placeholder="Stage Name"
                                    class="form-control" />
                                @error('Name') <span class="text-danger">*{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for>Description</label>
                                <input wire:model.blur="Remarks" type="text" placeholder="Stage Description"
                                    class="form-control" />
                                @error('Remarks') <span class="text-danger">*{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label for># Approvals Req</label>
                                <input wire:model.blur="MaxReqr" type="number" placeholder="Total Approval"
                                    class="form-control" />
                                @error('MaxReqr') <span class="text-danger">*{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label for># Rejections Req</label>
                                <input wire:model.blur="MaxRejReqr" type="number" placeholder="Total Rejection"
                                    class="form-control" />
                                @error('MaxRejReqr') <span class="text-danger">*{{ $message }}</span> @enderror
                            </div>
                

                        </div>

                        <div class="form-row">



                            <div class="form-group col-md-6">
                                <div class="m-1">
                                    <input type="text" wire:model.live="search" autocomplete="off" placeholder="Search Users"
                                        class="form-control col-md-12" />
                                </div>
                                <table class="table table-bordered table-hover table-sm">
                                    <thead class="thead-light">
                                        <tr>

                                            <th>User Code</th>
                                            <th>Name</th>
                                            <th></th>




                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $data)
                                        <tr>

                                            <td>{{$data->user->ExtUserCode}}</td>
                                            <td>{{$data->user->name}}</td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm"
                                                wire:click.prevent="addToList({{$data->user_id}})" wire:key="item-{{ $data->id }}">
                                                    Add
                                            </a>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="m-1">

                                    <label for="">Approvers</label>
                                    {{-- <input type="text" wire:model.live="search" autocomplete="off"
                                        placeholder="Search Users" class="form-control col-md-12" /> --}}
                                </div>
                                <table class="table table-bordered table-hover table-sm">
                                    <thead class="thead-light">
                                        <tr>

                                            <th>User Code</th>
                                            <th>Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listOfSelectedApprovers as $index=> $data)
                                        <tr>
                                          
                                            <td>{{$data['ExtUserCode']}}</td>
                                            <td>{{$data['name']}}</td>
                                            <td>
                                                <a href="#" wire:click.click="removeApproving({{$index}})">
                                                    <i class="fa fa-trash red"></i>
                                                </a>
                                            </td>


                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group col-md-6">

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>