@extends('layouts.master')

@section('content')

<div class="col-xs-12 ">
<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h4><b>DETALLES DEL PRECONTRATO {{$precontract[0]->siteAddress}}</b></h4></div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>N° {{__('precontract')}}</th>
                 <th>{{__('country')}}</th>
                 <th>COMPAÑIA</th>
                 <th>DIRECCION       </th>
                 <th>{{__('date')}}</th>
                 <th>{{__('client')}}</th>
                 </th>
                </tr>
            </thead>
          <tbody>
                <tr>
                    <td>{{$precontract[0]->preId}} </td>
                    <td>{{$precontract[0]->country->countryName}} </td>
                    <td>{{$precontract[0]->company->companyName}} </td>
                    <td>{{$precontract[0]->siteAddress}} </td>
                    <td>{{$precontract[0]->precontractDate}} </td>
                    <td>{{$precontract[0]->client->clientName}} </td>
                </tr>
        </tbody>
      </table>
     </div>

     <hr>

     <div class="text-center"><h4><b>DOCUMENTOS {{$precontract[0]->siteAddress}}</b></h4></div>
     <br>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
@can('BDGA')
    <li role="presentation" class="active "><a class="bg-info" href="#previous" aria-controls="previous" role="tab" data-toggle="tab"></a></li>
@endcan
  </ul>
  <!-- Tab panes -->
<div class="tab-content">
@can('BDGA')
    <div role="tabpanel" class="tab-pane active" id="previous">
        <br>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <grid-files-precontract precontract-id="{{$precontract[0]->precontractId}}" type-doc="previous"/>
   </div> <!--tab 1 final-->
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

