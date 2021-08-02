@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
        	<center>
       <a href="{{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
       </a>
</center>
              <datasheet-subcontractor pref-url="../../" subcontractor-id="{{$subcontId}}"/>
        </div>
      </div>

@endsection
