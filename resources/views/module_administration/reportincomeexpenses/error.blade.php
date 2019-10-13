@extends('layouts.master')

@section('content')
<div class="text-center">
<div class="panel panel-default col-xs-7 col-xs-offset-2">

    <H2 class="bg-success">Reporte de Ingreso y Egreso</H2>
      <br>
   <div class="col-xs-12">
      <h3 class="text-danger">Error: No existen registros asociados al Rango de Fecha Seleccionado, Intente con otro </h3>
  </div>
      <a class="btn btn-primary" href="{{route('transactions.incomeexpenses')}}"> Regresar </a>
	  <br><br>
  </div>
</div>
@endsection
