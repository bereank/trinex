@extends('layouts.master')
@section('main-content')
@livewire('expense.index', ['client_id' => $client_id])
@endsection