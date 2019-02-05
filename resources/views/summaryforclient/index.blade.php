@extends('layouts.master')

@section('content')
<div class="text-center">
<div class="panel panel-default col-xs-7 col-xs-offset-2">

    <H2 class="bg-success">Resumen Por Cliente</H2>
      <br>
   <div class="col-xs-offset-2">
    <form class="form" action="{{Route('reports.summaryForClient')}}" method="POST">
        {{ csrf_field() }}
      <div class="col-xs-9">
        <label for="clientId">{{__('client')}}</label>
        <select class="form-control" name="clientId" id="clientId">
            @foreach($clients as $client)
                  <option value="{{$client->clientId}}" > {{$client->clientName}} </option>
            @endforeach   
        </select>
        <br>
      <input class="btn btn-primary" type="submit" value="Buscar">
      <br><br>
      </div>
    
   </form>
  </div>
  
  </div>

</div>
@endsection
