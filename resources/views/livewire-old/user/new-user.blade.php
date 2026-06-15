<div>
    <form wire:submit="saveMember">
        <div class="modal-body">

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for>Name</label>
                    <input wire:model.blur="name" type="text" placeholder="Full Name" class="form-control" />
                    @error('FName') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for>Email</label>
                    <input wire:model.blur="email" type="email" placeholder="Email" class="form-control" />
                    @error('LName') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for>Phone</label>
                    <input wire:model.blur="Phone" type="number" placeholder="Phone Number" class="form-control" />
                    @error('Phone') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for>Password</label>
                    <input wire:model.blur="password" type="password" placeholder="Passwpord" class="form-control" />
                    @error('password') <span class="text-danger">*{{ $message }}</span> @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for>Role</label>
                    <select wire:model.blur="roleID" id="type" class="form-control">
                        <option value="">Choose Role</option>
                        <option value="1">Administrator</option>
                        <option value="2">User</option>
                    </select>

                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
