@extends('layouts.master')

@section('content')

<div class="col-xs-12 ">
<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h4><b>DETALLES DEL CONTRATO {{$contract[0]->siteAddress}}</b></h4></div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>N° {{__('contract')}}</th>
                 <th>{{__('country')}}</th>
                 <th>{{__('office')}}</th>
                 <th>DIRECCION       </th>
                 <th>{{__('date_of_contract')}}</th>
                 <th>{{__('client')}}</th>
                 <th>{{__('status')}}</th>
                 </th>
                </tr>
            </thead>
          <tbody>
                <tr>
                    <td>{{$contract[0]->contractNumber}} </td>
                    <td>{{$contract[0]->country->countryName}} </td>
                    <td>{{$contract[0]->office->officeName}} </td>
                    <td>{{$contract[0]->siteAddress}} </td>
                    <td>{{$contract[0]->contractDate}} </td>
                    <td>{{$contract[0]->client->clientName}} </td>
                    <td>{{$contract[0]->contractStatus }} </td>
                </tr>
        </tbody>
      </table>
     </div>

     <hr>

     <div class="text-center"><h4><b>DOCUMENTOS DEL CONTRATO {{$contract[0]->siteAddress}}</b></h4></div>
     <br>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
@can('BDGA')
    <li role="presentation" class="active "><a class="bg-info" href="#previous" aria-controls="previous" role="tab" data-toggle="tab">PREVIOS</a></li>
@endcan
@can('BDGB')    
    <li role="presentation"><a class="bg-info" href="#processed" aria-controls="processed" role="tab" data-toggle="tab">PROCESADOS</a></li>
@endcan
@can('BDGC')      
    <li role="presentation"><a class="bg-info" href="#revised" aria-controls="revised" role="tab" data-toggle="tab">REVISADOS</a></li>
@endcan
@can('BDGD')      
    <li role="presentation"><a class="bg-info" href="#ready" aria-controls="ready" role="tab" data-toggle="tab">LISTOS</a></li>
  </ul>
@endcan

  <!-- Tab panes -->
  <div class="tab-content">
@can('BDGA')
    <div role="tabpanel" class="tab-pane active" id="previous">
        <br>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <grid-files contract-id="{{$contract[0]->contractId}}" type-doc="previous"></grid-files>
   </div> <!--tab 1 final-->
@endcan    
@can('BDGB')
    <div role="tabpanel" class="tab-pane" id="processed">
      <br>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <grid-files contract-id="{{$contract[0]->contractId}}" type-doc="processed"></grid-files>
  </div>  <!--tab 2 final-->
@endcan    
@can('BDGC')
    <div role="tabpanel" class="tab-pane" id="revised">
      <br>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <grid-files contract-id="{{$contract[0]->contractId}}" type-doc="revised"></grid-files>
  </div>  <!--tab 3 final-->
@endcan    
@can('BDGD')
    <div role="tabpanel" class="tab-pane" id="ready">
      <br>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <grid-files contract-id="{{$contract[0]->contractId}}" type-doc="ready"></grid-files>
  </div>  <!--tab 4 final-->
@endcan    

</div><!--tab container final-->
<br>
    <div class="text-center">
        <a href="{{URL::previous()}}" class="btn btn-warning">
            <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
        </a>
    </div>
    <br>
@endsection

