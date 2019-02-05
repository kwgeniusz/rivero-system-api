@extends('layouts.master')

@section('content')
<div class="text-center">
<div class="panel panel-default col-xs-7 col-xs-offset-2">

    <H2 class="bg-success">Reporte de Ingreso y Egreso</H2>
      <br>
   <div class="col-xs-12">
    <form class="form" action="{{Route('reports.incomeexpenses')}}" method="POST">
        {{ csrf_field() }}
      <div class="col-xs-12">
      
        <div class="col-xs-6">
          <div class="form-group">
            <label for="date1">DESDE</label>
            <input type="date" class="form-control" id="date1" name="date1" value="{{ old('date1') }}" required>
          </div>
        </div>
        <div class="col-xs-6">
          <div class="form-group">
            <label for="date2">HASTA</label>
            <input type="date" class="form-control" id="date2" name="date2" value="{{ old('date2') }}" required>
        </div>
      
      </div>
      <button type="submit" class="btn btn-primary">
        <span class="fa fa-search" aria-hidden="true"></span> Buscar
   </button>
     
   <br><br>
   </form>
  </div>

  </div>
</div>
@endsection
