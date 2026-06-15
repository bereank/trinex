<div>
    <div class="card row mt-2 col-md-8">
        <div class="card-header">
            <h3 class="card-title">Create Approval Stages</h3>
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
                <form wire:submit="createTemplate">
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for>Database <i class="text-danger"> *</i></label>
                                <select wire:model.live="client_id" id="type" class="form-control">
                                    <option value="">Select Database</option>
                                    @foreach ($userDatabases as $val)
                                    <option value="{{$val->client_id}}">{{$val->dbdetails->db_name}}</option>
                                    @endforeach
                                </select>
                                @error('client_id') <span class="text-danger">*{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for>Template Name</label>
                                <input wire:model.blur="Name" type="text" placeholder="Template Name"
                                    class="form-control" />
                                @error('Name') <span class="text-danger">*{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for>Template Description</label>
                                <input wire:model.blur="Remarks" type="text" placeholder="Template Remarks"
                                    class="form-control" />
                                @error('Remarks') <span class="text-danger">*{{ $message }}</span> @enderror
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