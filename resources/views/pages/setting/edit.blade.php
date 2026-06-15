@extends('layouts.master')
@section('main-content')
@livewire('student.edit', ['student' => $student])
@endsection
