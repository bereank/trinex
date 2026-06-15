@extends('layouts.master')
@section('main-content')

@livewire('approvals.a-stages.edit', ['id' => $id])

@endsection
