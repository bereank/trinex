@extends('layouts.master')
@section('main-content')
@livewire('expense.expense-report', ['client_id' => $client_id])
@endsection