<div>
    <form wire:submit="saveMember">
        <div class="modal-body">
            @if (session()->has('messageE'))
            <div class="alert alert-danger">
                {{ session('messageE') }}
            </div>
            @endif
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for>First Name</label>
                    <input wire:model.blur="FName" type="text" placeholder="First Name" class="form-control" />
                    @error('FName') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for>Last Name</label>
                    <input wire:model.blur="LName" type="text" placeholder="Last Name" class="form-control" />
                    @error('LName') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for>Gender</label>
                    <select name="type" wire:model.blur="Gender" class="form-control">
                        <option value="">Choose Gender</option>

                        <option value="F">Female</option>
                        <option value="M">Male</option>
                    </select>
                    @error('Gender') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-12">
                    <label for>Phone</label>
                    <input wire:model.blur="Phone" type="number" placeholder="Phone Number" class="form-control" />
                    @error('Phone') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for>District</label>
                    <select name="type" wire:model.blur="District" class="form-control">
                        <option value="">Choose District</option>

                        <option value="1">UNDUGU</option>
                        <option value="1">EMMANUEL</option>
                        <option value="1">UMOJA</option>
                    </select>
                    @error('District') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for>Occupation</label>
                    <input wire:model.blur="Occupation" type="text" placeholder="Occupation" class="form-control" />
                    @error('Occupation') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
