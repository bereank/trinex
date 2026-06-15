@extends('layouts.master')
@section('main-content')
@livewire('expense.edit', ['client_id' => $client_id,'expense_id' => $expense_id])
@endsection