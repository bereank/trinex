<div class="card row mt-2">
    <div class="card-header">
        <h3 class="card-title">Approval Stages</h3>
        <div class="card-tools">

            <a href="{{ route('stages.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i>
                New
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
            <div class="m-1">
                <input type="text" wire:model.live="search" autocomplete="off" placeholder="Search Approval Stages"
                    class="form-control col-md-12" />
            </div>
            <table class="table table-bordered table-hover table-sm">
                <thead class="thead-light">
                    <tr>

                        <th>Database</th>
                        <th>Name</th>
                        <th>Remarks</th>
     
                        <th>Edit</th>
                        <th>Delete</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($astages as $data)
                    <tr>

                        <td>{{$data->client_id}}</td>
                        <td>{{$data->Name}}</td>
                        <td>{{$data->Remarks}}</td>
              
        
                        <td>
                            <a href="{{ route('stages.edit', $data->id) }}">
                                <i class="fa fa-edit blue">Edit</i></a>

                        </td>

                        <td>
                            <a href="#"  wire:click.click="deleteStage({{$data->id}})">
                                <span class="badge badge-danger rounded-pill d-inline">
                                   Delete
                                </span>
                            </a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $astages->links() }}
        </div>

    </div>
</div>