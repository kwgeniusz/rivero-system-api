@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
        	<center>
       <a href="{{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
       </a>
</center>
              <subcontractor-datasheet pref-url="../../" subcontractor-id="{{$subcontId}}"></subcontractor-datasheet>
        </div>
      </div>

@endsection
