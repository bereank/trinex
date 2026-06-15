<div class="card row mt-2">
    <div class="card-header">
        <h3 class="card-title">Users</h3>

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
            <div class="m-1">
                <input type="text" wire:model.live="search" autocomplete="off" placeholder="Search Users"
                    class="form-control col-md-12" />
            </div>
            <table class="table table-bordered table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                       
                        <th>User Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Actions</th>
                        <th>Edit</th>
                    

                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $data)
                    <tr>
                      
                        <td>{{$data->ExtUserCode}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->email}}</td>
                        <td>
                            @if ($data->UserType ==0)
                            <span class="badge badge-success rounded-pill d-inline">Normal user</span>
                            @elseif($data->UserType ==1)
                            <span class="badge badge-primary rounded-pill d-inline">Manager</span>
                            @else
                            <span class="badge badge-secondary rounded-pill d-inline">Super Admin</span>
                            @endif
                        </td>
                        <td>

                            @if ($data->UserType ==0)
                            <a href="#" wire:click="markAsApprover({{$data->id}})">
                                <span class="badge badge-warning rounded-pill d-inline">
                                    Mark As Approver
                                </span>
                            </a>
                            @endif

                            @if ($data->UserType ==1)
                            <a href="#" wire:click="removeFromApproversList({{$data->id}})">
                                <span class="badge badge-danger rounded-pill d-inline">
                                    Deactivate
                                </span>
                            </a>
                            @endif

                            
                        </td>

                        <td>
                            <a href="{{ route('users.edit', $data->id) }}">
                                <i class="fa fa-edit blue">Edit</i></a>

                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>

    </div>
</div>