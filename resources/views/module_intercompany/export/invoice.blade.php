@extends('layouts.master')

@section('content')
  <intercompany-export-invoice invoice-id="{{$id}}"/>
@endsection
