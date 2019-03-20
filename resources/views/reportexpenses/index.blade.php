@extends('layouts.master')

@section('content')
<div class="col-xs-7 col-xs-offset-2 text-center">
<div class="panel panel-danger">
    <div class="panel-heading">  <h3><b>Reporte de Egreso</b></h3></div>
    <div class="panel-body">

    <form class="form" action="{{Route('reports.expenses')}}" method="POST">
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
      <input type="hidden" name="sign" value="-">
      <button type="submit" class="btn btn-primary">
        <span class="fa fa-search" aria-hidden="true"></span> Buscar
   </button>
   <br><br>
   </form>
  </div>

  </div>
</div>
@endsection
