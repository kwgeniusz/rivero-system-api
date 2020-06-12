@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
              <subcontractor-datasheet pref-url="../../" subcontractor-id="{{$subcontId}}"></subcontractor-datasheet>
        </div>
      </div>

@endsection
