<div>
    <div class="row mt-2">

        <div class="card  col-md-8">
            <div class="card-header">
                <h3 class="card-title">Edit Student</h3>
                <div class="card-tools">
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <form wire:submit="createStudent">
                    <div class="modal-body">

                        <div class="form-row">
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

                        <div class="form-row">

                            <table class="table table-bordered table-hover table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th><input type="checkbox" wire:model.live="selectAll"></th>
                                        <th>Adm</th>
                                        <th>Name</th>
                                        <th>Frm</th>
                                        <th>Str</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $data)
                                    <tr>
                                        <td>
                                            <input type="checkbox" wire:model="selectedUsers"
                                                value="{{$data->id}}">
                                        </td>
                                        <td>{{$data->adm_no}}</td>
                                        <td>{{$data->student_name}}</td>
                                        <td>{{$data->form->Name}}</td>
                                        <td>{{$data->stream->Name}}</td>
                                        <td>
                                            @if ($data->status ==1)
                                            <span class="badge badge-success rounded-pill d-inline">Active</span>
                                            @else
                                            <span class="badge badge-danger rounded-pill d-inline">In Active</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </form>
            </div>

        </div>

        <div class="card  col-md-4">

            <div class="form-row">
                <div class="form-group mt-2 col-md-12">
                    <label for>Total Selected</label>
                    <input type="text" readonly placeholder="Total Selected" value="{{count($selectedUsers)}}"
                        class="form-control" />
                </div>
                <div class="form-group col-md-12">

                    <h5>Action Type</h5>
                    <label>
                        <input type="checkbox" wire:model.live="promote">
                        Promote
                    </label>
                    <label>
                        <input type="checkbox" wire:model.live="archive">
                        Archive
                    </label>
                </div>
            </div>

            @if ($promote)
            <div class="form-row mt-4">
                <div class="form-group col-md-6">
                    <label for>Form 1</label>
                    <select wire:model.live="form_id_edit" class="form-control">
                        <option value="">Select Form</option>
                        @foreach ($forms as $val)
                        <option value="{{$val->id}}">{{$val->Name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for>Stream</label>
                    <select wire:model.live="stream_id_edit" " class=" form-control">
                        <option value="">Select Stream</option>
                        @foreach ($streams as $val)
                        <option value="{{$val->id}}">{{$val->Name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            @endif

            <div class="form-row">
                <div class="modal-footer">
                    <button wire:click="saveData" class="btn btn-primary form-control">Submit</button>
                </div>
            </div>




        </div>


    </div>

</div>
