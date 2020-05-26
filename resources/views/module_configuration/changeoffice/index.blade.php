@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-lg-7 col-lg-offset-2">
<div class="panel panel-info">
    <div class="panel-heading text-center"> <h3><b>Cambiar de Oficina</b></h3></div>
    <div class="panel-body">
        <form class="form" action="{{Route('changeOffice.update')}}" method="POST">
        {{csrf_field()}}
 
  
             <div class="form-group col-xs-12 col-lg-7">
                <label for="user">Usuario</label>
                <input type="text" class="form-control" id="user" name="user" value="{{ Auth::user()->fullName }}" placeholder="Nombres y Apellidos" disabled="on">
             </div>
               <br><br>
               <div class="col-xs-12">
                  <select-country-office pref-url="./"></select-country-office>
               </div>
            <br><br><br>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  Ejecutar
              </button>
              <a href="{{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>

          </form>


      </div>
    </div>
  </div>
@endsection