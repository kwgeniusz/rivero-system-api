@extends('layouts.master')

@section('content')
    <h3 class="text-success"><b>CONTRATOS FINALIZADOS</b> </h3>
    <br>
    <div class="row">
        <div class="col-xs-12 ">



         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead class="bg-success">
                <tr>
                        <th>ID</th>
                        <th>N° {{__('contract')}}</th>
                        <th>COD. {{__('client')}}</th>
                        <th>{{__('name')}}</th>   
                        <th>{{__('address')}}</th>
                        <th>BUILDING CODE</th>
                        <th>DESCRIPTION</th>
                        <th>USO</th>
                        <th>TIPO</th>
                        <th>{{__('status')}}</th>
                        <th>{{__('actions')}}</th>
                 </th>
                </tr>
            </thead>
                <tbody>
                @foreach($contracts as $contract)
                <tr>
                     <td>{{$contract->conId}} </td>
                    <td>{{$contract->contractNumber}} </td>
                    <td>{{$contract->client->clientCode}}</p></td>
                    <td>{{$contract->client->clientName}}   </td>  
                       <td >{{$contract->propertyNumber}}
                        {{$contract->streetName}}
                        {{$contract->streetType}}
                        {{$contract->suiteNumber}}
                        {{$contract->city}}
                        {{$contract->state}}
                        {{$contract->zipCode}}   </td>
                    <td>{{$contract->buildingCode->buildingCodeName}}   </td>
                    <td>{{$contract->projectDescription->projectDescriptionName}}   </td>
                    <td>{{$contract->projectUse->projectUseName}}   </td>
                    <td>{{$contract->contractType}}   </td>
                    <td>{{$contract->contractStatus}}   </td>


                   <td>
                       <a href="{{route('contracts.changeStatus', ['id' => $contract->contractId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('status')}}">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                    </a>
                    <a href="{{route('contracts.finishedDetails', ['id' => $contract->contractId])}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="{{__('see')}}">
                        <span class="fa fa-search" aria-hidden="true"></span>
                    </a>
                       @can('BCG') 
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
