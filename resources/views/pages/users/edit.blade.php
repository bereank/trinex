@extends('layouts.master')
@section('main-content')

<div class="card row mt-2">
    <div class="card-header">
        <h3 class="card-title">Edit User</h3>
        <div class="card-tools">
            <a href="{{ route('system.users') }}" class="btn btn-success btn-sm">
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
        @livewire('user.edit-user', ['user_id' => $user_id])
    </div>
</div>


@endsection
