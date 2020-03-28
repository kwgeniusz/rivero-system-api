@extends('layouts.master')

@section('content')
<div class="col-xs-7 col-xs-offset-2 text-center">
<div class="panel panel-success">
    <div class="panel-heading">  <h3><b>Resumen Por Cliente</b></h3></div>
    <div class="panel-body">

    <form class="form" action="{{Route('reports.summaryForClient')}}" method="POST">
        {{ csrf_field() }}
<!--     <div class="col-xs-6 col-xs-offset-3 ">
        <label for="clientId">{{__('client')}}</label>
        <select class="form-control" name="clientId" id="clientId">
            @foreach($clients as $client)
                  <option value="{{$client->clientId}}" > {{$client->clientName}} </option>
            @endforeach
        </select>
        <br> -->
          <div class="col-xs-12 col-xs-offset-2">
            <search-client pref-url='./'></search-client>
          </div> 

          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary">
                <span class="fa fa-search" aria-hidden="true"></span> Buscar
           </button>
         </div> 
   

   </form>
  </div>

  </div>

</div>
@endsection
