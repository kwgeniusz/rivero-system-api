@extends('layouts.master')

@section('content')
<div class="text-center">
<div class="panel panel-default col-xs-7 col-xs-offset-2">

    <H2 class="bg-success">Imprimir Contrato</H2>
      <br>
   <div class="col-xs-offset-3">
    <form class="form" action="{{Route('reports.contract')}}" method="POST">
        {{ csrf_field() }}
      <div class="col-xs-8">
       <print-contract></print-contract>
      </div>
   </form>
  </div>

  </div>
</div>
@endsection
