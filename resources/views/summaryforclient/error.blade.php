@extends('layouts.master')

@section('content')
<div class="col-xs-7 col-xs-offset-2 text-center">
<div class="panel panel-success">
    <div class="panel-heading">  <h3><b>Resumen Por Cliente</b></h3></div>
    <div class="panel-body">
    <br>
      <div class="col-xs-12">
      <h3 class="text-danger">Error: No existen registros asociados al Cliente, Intente con otro </h3>
      </div>
      <a class="btn btn-primary" href="{{route('contracts.summaryForClient')}}"> Regresar </a>
	  <br><br>
  </div>

  </div>

</div>
@endsection
