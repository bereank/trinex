@extends('layouts.master')
@section('main-content')
@livewire('expense.create', ['client_id' => $client_id])
@endsection