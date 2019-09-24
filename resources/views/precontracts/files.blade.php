@extends('layouts.master')

@section('content')

<div class="col-xs-12 ">
<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h4><b>DETALLES DEL PRE-CONTRATO</b></h4></div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>N° PRE-CONTRATO</th>
                 <th>{{__('country')}}</th>
                 <th>{{__('office')}}</th>
                 <th>{{__('client')}}</th>
                   <th>{{__('address')}}</th>
                 </th>
                </tr>
            </thead>
          <tbody>
                <tr>
                    <td>{{$precontract[0]->precontractId}} </td>
                    <td>{{$precontract[0]->country->countryName}} </td>
                    <td>{{$precontract[0]->office->officeName}} </td>
                    <td>{{$precontract[0]->client->clientName}} </td>
                    <td>{{$precontract[0]->siteAddress}} </td>
                </tr>
        </tbody>
      </table>
     </div>

     <hr>
    <div class="text-center"><h4><b>DOCUMENTOS DEL CONTRATO</b></h4></div>
     <br>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active "><a class="bg-info" href="#previous" aria-controls="previous" role="tab" data-toggle="tab">PREVIOS</a></li>
    <li role="presentation"><a class="bg-info" href="#processed" aria-controls="processed" role="tab" data-toggle="tab">PROCESADOS</a></li>
    <li role="presentation"><a class="bg-info" href="#revised" aria-controls="revised" role="tab" data-toggle="tab">REVISADOS</a></li>
    <li role="presentation"><a class="bg-info" href="#ready" aria-controls="ready" role="tab" data-toggle="tab">LISTOS</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="previous">
        <br>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <grid-files contract-id="{{$contract[0]->contractId}}" type-doc="1"></grid-files>
   </div> <!--tab 1 final-->

    <div role="tabpanel" class="tab-pane" id="processed">
      <br>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <grid-files contract-id="{{$contract[0]->contractId}}" type-doc="2"></grid-files>
  </div>  <!--tab 2 final-->

    <div role="tabpanel" class="tab-pane" id="revised">
      <br>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <grid-files contract-id="{{$contract[0]->contractId}}" type-doc="3"></grid-files>
  </div>  <!--tab 3 final-->

    <div role="tabpanel" class="tab-pane" id="ready">
      <br>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <grid-files contract-id="{{$contract[0]->contractId}}" type-doc="4"></grid-files>
  </div>  <!--tab 4 final-->

</div><!--tab container final-->


    <div class="text-center">
        <a href="{{route('precontracts.index')}}" class="btn btn-warning">
            <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
        </a>
    </div>
    <br>



@endsection

