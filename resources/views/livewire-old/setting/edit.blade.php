<div>
    <div class="card row mt-2 col-md-6">
        <div class="card-header">
            <h3 class="card-title">Edit Student</h3>
            <div class="card-tools">

                <a href="#" class="btn btn-danger btn-sm" wire:click="deleteStudent({{$studentId}})">
                    <i class="fas fa-plus"></i>
                    Delete Student
                </a>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <form wire:submit="editStudent">
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for>Admission No.</label>
                            <input wire:model.blur="adm_no" type="number" placeholder="Admission Number"
                                class="form-control" />
                            @error('adm_no') <span class="text-danger">*{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for>Name</label>
                            <input wire:model.blur="student_name" type="text" placeholder="Full Name"
                                class="form-control" />
                            @error('student_name') <span class="text-danger">*{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for>Form</label>
                            <select wire:model.blur="form_id" id="type" class="form-control">
                                <option value="">Select Form</option>
                                @foreach ($forms as $val)
                                <option value="{{$val->id}}">{{$val->Name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for>Stream</label>
                            <select wire:model.blur="stream_id" id="type" class="form-control">
                                <option value="">Select Stream</option>
                                @foreach ($streams as $val)
                                <option value="{{$val->id}}">{{$val->Name}}</option>
                                @endforeach
                            </select>

                        </div>


                    </div>

                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>

    </div>

</div>
