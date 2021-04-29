@extends('layouts.master')

@section('content')
    <h3 class="text-success"><b>CONTRATOS FINALIZADOS</b> </h3>

     <div class="row ">
      <div class="col-xs-12 text-center">
      <form class="form-inline" action="{{Route('contracts.finished')}}" method="GET">

         <div class="form-group">
           <label for="filteredOut"></label>
           <input type="text" class="form-control" name="filteredOut" id="filteredOut" placeholder="Filtrado" autocomplete="off">
         </div>
          <button type="submit" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Buscar">
                <span class="fa fa-search" aria-hidden="true"></span>
           </button>
        </form>
      </div>
    </div>

    <br>
    <div class="row">
        <div class="col-xs-12 ">
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead class="bg-success">
                <tr>
                        <th rowspan="2">ID</th>
                        <th rowspan="2">N° {{__('contract')}}</th>
                        <th rowspan="2">COD. {{__('client')}}</th>
                        <th rowspan="2">{{__('name')}}</th>   
                        <th rowspan="2">{{__('address')}}</th>
                        <th rowspan="2">DESCRIPTION</th> 
                        <th rowspan="2">USO</th>
                        <th rowspan="2">TIPO</th>
                        <th colspan="4">DOCUMENTOS</th>
                        <th rowspan="2">{{__('actions')}}</th>
                </tr>
                <tr>
                    <td class="">PREVIOS</td>
                    <td class="">PROCESADOS</td>
                    <td class="">REVISADOS</td>
                    <td class="">LISTOS</td>
                  </tr>
            </thead>
                <tbody>
              
               @php $acum=0;@endphp
                @foreach($contracts as $contract)
                <tr>
                     <td>{{++$acum}} </td>
                    <td>{{$contract->contractNumber}}
                     @can('BDE')
                       <comments-contract pref-url="" 
                         contract-id="{{$contract->contractId}}"
                         contract-number="{{$contract->contractNumber}}">
                       </comments-contract>
                      @endcan
                     </td>
                    <td>{{$contract->client->clientCode}}</p></td>
                    <td>{{$contract->client->clientName}}   </td>  
                       <td >{{$contract->propertyNumber}}
                        {{$contract->streetName}}
                        {{$contract->streetType}}
                        {{$contract->suiteNumber}}
                        {{$contract->city}}
                        {{$contract->state}}
                        {{$contract->zipCode}}   </td>
                        <td> 
                     @foreach($contract->invoice as $inv)
                       - {{$inv->projectDescription->projectDescriptionName}}<br>
                        @endforeach 
                        </td> 
                    <td>{{$contract->projectUse->projectUseName}}   </td>
                    <td>{{$contract->contractType}}   </td>
                  @foreach ($contract->numberOfDocuments as $key => $value)
                    <td>{{$value}}</td>
                  @endforeach

                   <td>
                       <a href="{{route('contracts.changeStatus', ['id' => $contract->contractId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('status')}}">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                    </a>
                    <a href="{{route('contracts.finishedDetails', ['id' => $contract->contractId])}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="{{__('see')}}">
                        <span class="fa fa-search" aria-hidden="true"></span>
                    </a>
                     @can('BE')
                        <a href="{{url("invoices?id=$contract->contractId")}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Facturas">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                        @endcan  
                       @can('BDG') 
                    <a href="{{route('contracts.files', ['id' => $contract->contractId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Documentos">
                     <span class="fa fa-file" aria-hidden="true"></span> 
                    </a>
                  @endcan
                <!--        <a href="{{route('contracts.finishedShow', ['id' => $contract->contractId])}}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}"> 
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  
                        </a> -->
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
<div class="text-center">
       <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
</div>

    </div>
</div>

@endsection
