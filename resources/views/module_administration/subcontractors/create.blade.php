@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
        <h3><b>CREAR SUBCONTRATISTA</b></h3>
             <a href="{{route('subcontractors.index')}}" class="btn btn-warning">
              <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
             </a>

         <subcontractor-create></subcontractor-create>

        </div>
      </div>
@endsection