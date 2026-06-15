@extends('layouts.master')
@section('main-content')
@livewire('book.issued', ['book' => $book])
@endsection
