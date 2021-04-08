@extends('layouts.master')

@section('content')
    <!-- <div class="row">
        <div class="col-xs-12 ">

        <h3><b>CREAR SUBCONTRATISTA</b></h3>
         <div class="text-center">
             <a href="{{route('subcontractors.index')}}" class="btn btn-warning">
              <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
             </a>
         </div>
          <br>
          
         <subcontractor-create></subcontractor-create>

        </div>
      </div> -->
@section('content')
   <main-subcontractor/>
@endsection

@endsection