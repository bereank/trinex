<div>
    <div class="card row mt-2 col-md-6">
        <div class="card-header">
            <h3 class="card-title">Create Book Name</h3>
            <div class="card-tools">
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <form wire:submit="createData">
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for>Subject</label>
                            <select wire:model.blur="subject_id" id="type" class="form-control">
                                <option value="">Select Subject</option>
                                @foreach ($subjects as $val)
                                <option value="{{$val->id}}">{{$val->name}}</option>
                                @endforeach
                            </select>
                            @error('subject_id') <span class="text-danger">*{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for>Name</label>
                            <input wire:model.blur="book_name" type="text" placeholder="Book Name"
                                class="form-control" />
                            @error('book_name') <span class="text-danger">*{{ $message }}</span> @enderror
                        </div>



                    </div>

                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>

    </div>

</div>
