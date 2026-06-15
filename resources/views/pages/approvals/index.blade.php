@extends('layouts.master')
@section('main-content')


@livewire('approvals.index', ['client_id' => $client_id])
@endsection
