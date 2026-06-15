@extends('layouts.master')
@section('main-content')
@livewire('approvals.view', ['client_id' => $client_id,'ObjType' => $ObjType,'WddCode' => $WddCode,'draftEntry' => $draftEntry])
@endsection
