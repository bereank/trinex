@extends('layouts.master')
@section('main-content')


@livewire('approvals.report', ['client_id' => $client_id])
@endsection
