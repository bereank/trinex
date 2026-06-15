<div>

    <div class="card row mt-2">
        <div class="card-header">
            <h3 class="card-title">Book Issued</h3>

            <div class="card-tools">
                <a href="{{ route('book.index') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-solid fa-backward"></i>
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
            <div class="m-2">
                <input type="text" wire:model.live="book_search" autocomplete="off" placeholder="Search By Adm No."
                    class="form-control col-md-4" />
            </div>
            <table class="table table-bordered table-hover table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>Adm</th>
                        <th>Student Name</th>
                        <th>Form</th>
                        <th>Stream</th>
                        <th>Subject</th>
                        <th>Book No</th>
                        <th>Book Name</th>
                        <th>Issued On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookissued as $data)
                    <tr>
                        <td>{{$data->student->adm_no}}</td>
                        <td>{{$data->student->student_name}}</td>
                        <td>{{$data->form_name}}</td>
                        <td>{{$data->stream_name}}</td>
                        <td>{{$data->book->bookssetting->subject->name}}</td>
                        <td>{{$data->book->book_no}}</td>
                        <td>{{$data->book->bookssetting->book_name}}</td>
                        <td>{{$data->DateIssued}}</td>
                        <td>
                            <a href="#" wire:click="returnBook({{$data->id}})">
                                <span class="badge badge-success rounded-pill d-inline">
                                    Return
                                </span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
