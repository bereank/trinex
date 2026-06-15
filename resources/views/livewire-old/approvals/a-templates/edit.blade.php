<div>
    <div class="card row mt-2">
        <div class="card-header">
            <h3 class="card-title">Edit Approval Template ||||| {{$Name}}</h3>
            <div class="card-tools">
                <a href="{{ route('templates.index') }}" class="btn btn-success btn-sm">
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
                <form #>
                    <div class="modal-body">

                        <div class="form-row">




                        </div>

                        <div class="form-row">



                            <div class="form-group col-md-6">
                                <div class="m-1">
                                    <input type="text" wire:model.live="search" autocomplete="off"
                                        placeholder="Search Approval Stages" class="form-control col-md-12" />
                                </div>
                                <table class="table table-bordered table-hover table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Remarks</th>
                                            <th>No. of Approvals Required</th>
                                            <th>No. of Rejections Required</th>
                                            <th></th>




                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stages as $data)
                                        <tr>


                                            <td>{{$data->Name}}</td>
                                            <td>{{$data->Remarks}}</td>
                                            <td>{{$data->MaxReqr}}</td>
                                            <td>{{$data->MaxRejReqr}}</td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm"
                                                    wire:click="addToList({{$data->id}})">
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

                                    <label for="">Selected Approval Stages</label>
                                    {{-- <input type="text" wire:model.live="search" autocomplete="off"
                                        placeholder="Search Users" class="form-control col-md-12" /> --}}
                                </div>
                                <table class="table table-bordered table-hover table-sm">
                                    <thead class="thead-light">
                                        <tr>


                                            <th>Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listOfStages as $index=> $data)
                                        <tr>


                                            <td>{{$data->approvalstage->Name}}</td>
                                            <td>
                                                <a href="#" wire:click="removeApproving({{$data->id}})">
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

                </form>


            </div>
        </div>
    </div>

    

</div>