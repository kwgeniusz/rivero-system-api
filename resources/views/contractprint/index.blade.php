@extends('layouts.master')

@section('content')
<div class="col-xs-7 col-xs-offset-2 text-center">
<div class="panel panel-success">
    <div class="panel-heading">  <h3><b>Imprimir Contrato</b></h3></div>
    <div class="panel-body">

       <form class="form" action="{{Route('reports.contract')}}" method="POST">
          {{ csrf_field() }}
           <div class="col-xs-6 col-xs-offset-3">
            <print-contract></print-contract>
           </div>
        </form>

  </div>
</div>
</div>
@endsection
