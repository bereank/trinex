@extends('layouts.master')
@section('main-content')

@livewire('approvals.a-templates.edit', ['id' => $id])

@endsection
