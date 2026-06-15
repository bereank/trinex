@extends('layouts.landing')
@section('main-content')
<div class="modal-content col-md-6 mt-2">
    <div class="modal-header">
        <h5 class="modal-title" id="addNewLabel">SAP Password Reset</h5>
    </div>
    @if (session()->has('error'))
    <div class="alert alert-danger col-md-6">
        {{ session('error') }}
    </div>
    @endif

    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <livewire:setting.sap-password />
</div>
@endsection
