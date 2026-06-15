<div>

    <div class="card row mt-2 col-md-8">

        <div class="card-header">
            <h3 class="card-title">Setting</h3>
            <div class="card-tools">

                <a href="{{ route('setting.new') }}" class="btn btn-success btn-sm">
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

            <table class="table table-bordered table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>Subject</th>
                        <th>Name</th>
                        <th># Of Books</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $data)
                    <tr>

                        <td>{{$data->subject->name}}</td>
                        <td>{{$data->book_name}}</td>
                        <td>{{$data->book_count}}</td>
                        <td>
                            <a href="">
                                <i class="fa fa-trash red"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $students->links() }}
        </div>
    </div>



</div>
