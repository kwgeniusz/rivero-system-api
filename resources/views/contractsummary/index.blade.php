@extends('layouts.master')

@section('content')
<div class="text-center">
<div class="panel panel-default col-xs-7 col-xs-offset-2">

    <H2 class="bg-success">Resumen por Oficina</H2>
      <br>
   <div class="col-xs-offset-2">
    <form class="form" action="{{Route('reports.summaryContract')}}" method="POST">
        {{ csrf_field() }}
      <div class="col-xs-9">
       <contract-summary></contract-summary>
      </div>
   </form>
  </div>

  </div>
</div>
@endsection
