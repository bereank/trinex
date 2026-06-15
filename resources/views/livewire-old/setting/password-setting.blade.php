<div>

    <div class="card row mt-2 col-md-8">

        <div class="card-header">
            <h3 class="card-title">Set SAP Password</h3>

            {{-- <div class="card-tools">
                <a href="{{ route('resetsappassword') }}" target="_blank" class="btn btn-success btn-sm">

                    Reset SAP Password


                </a>
            </div> --}}
        </div>
        @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Success!</strong> {{session('message')}}.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        @endif

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <form wire:submit="updateSAPPassword">
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for>Choose Databae</label>
                            <select wire:model.live="client_id" id="type" class="form-control">
                                <option value="">Choose Database</option>
                                @foreach ($databases as $val)
                                <option value="{{$val->id}}">{{$val->dbdetails->db_name}}</option>
                                @endforeach
                            </select>
                            @error('client_id') <span class="text-danger">*{{ $message }}</span> @enderror
                        </div>


                        <div class="form-group col-md-12">
                            <label for>Password</label>
                            <input wire:model.blur="SapPassword" type="password" placeholder="SAP Password"
                                class="form-control" />
                            @error('SapPassword') <span class="text-danger">*{{ $message }}</span> @enderror
                        </div>




                        <hr>
                        @if($this->resetSapPassword)
                        <div class="form-group col-md-8">
                            <label for>Enter Verification Code Sent To your Email</label>
                            <input wire:model.blur="SapPassword" type="password"
                                placeholder="SAP Password Reset Verirication Code" class="form-control" />
                            @error('SapPassword') <span class="text-danger">*{{ $message }}</span> @enderror
                            <a href="#" wire:click="resendVerificationCode">
                                <span class="badge badge-suc-cess rounded-pill d-inline">
                                    Resend Verification Code
                                </span>
                            </a>

                        </div>
                        @endif

                    </div>

                </div>
                <div class="modal-footer">

                    <div wire:loading wire:target="updateSAPPassword">
                        Submitting Request.......
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

        </div>
    </div>



</div>