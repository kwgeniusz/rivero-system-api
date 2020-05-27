@extends('layouts.master')

@section('content')


  <h3><b>PRE-CONTRATOS</b></h3>


   <div class="row ">
      <div class="col-xs-12 text-center">
      <form class="form-inline" action="{{Route('precontracts.index')}}" method="GET">

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
            <br>
            <div class="text-center">
        @can('BCA')
            <a href="{{ route('precontracts.create') }}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                 Agregar Pre-contrato
            </a>
        @endcan
              <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
           </div>
           <br>
      </div>
    </div>

    <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
             <thead>
                <tr>
                 <th>#</th>
                 <th>N° PRECONTRATO</th>
                 <th>COD. {{__('client')}}</th>
                 <th>{{__('name')}}</th>   
                 {{-- <th>NOMBRE PROYECTO</th>    --}}
                 <th>{{__('address')}}</th>
                 <th>BUILDING CODE</th>
                 <th>DESCRIPCION</th>
                 <th>USO</th>
                 <th>TIPO</th>
                 <th>{{__('options')}}</th>
                </tr>
            </thead>
                <tbody>
                 @php $acum=0; @endphp
                @foreach($precontracts as $precontract)
                <tr>
                   <td>{{++$acum}}</td>
                    <td>{{$precontract->preId}} </td>
                    <td>{{$precontract->client->clientCode}}   </td>
                    <td>{{$precontract->client->clientName}}   </td>  
                    {{-- <td>{{$precontract->projectName}}   </td>   --}}
                    <td >{{$precontract->propertyNumber}}
                        {{$precontract->streetName}}
                        {{$precontract->streetType}}
                        {{$precontract->suiteNumber}}
                        {{$precontract->city}}
                        {{$precontract->state}}
                        {{$precontract->zipCode}}   </td>
                    <td >{{$precontract->buildingCode->buildingCodeName}}   </td>
                    <td >
                     {{-- {{ $precontract->proposal}} --}}
                       @foreach($precontract->proposal as $pd)
                       - {{$pd->projectDescription->projectDescriptionName}}<br>
                        @endforeach
                     </td>
                    <td >{{$precontract->projectUse->projectUseName}}   </td>
                    <td >{{$precontract->contractType}}   </td>
                    <td>
        @if($precontract->contractId == null)
              @can('BBE')
         <!--<a href="{{route('precontracts.convert', ['id' => $precontract->precontractId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Convertir en Contrato">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                    </a> -->
                  <modal-convert-precontract pref-url="./" precontract-id="{{$precontract->precontractId}}"></modal-convert-precontract>

              @endcan      
              @can('BBD')
                     <a href="{{url("/proposals?id=$precontract->precontractId")}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Propuesta">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                 @endcan      
              @can('BBB')     
                    <a href="{{route('precontracts.edit', ['id' => $precontract->precontractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
                @endcan      
              @can('BBC')      
                    <a href="{{route('precontracts.show', ['id' => $precontract->precontractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a>
              @endcan      
                 </td>

                </tr>
            @else
              <a class="btn btn-primary btn-sm" href="{{url("invoices?id=$precontract->contractId")}}">Ir a Contrato</a>
                <a href="{{url("/proposals?id=$precontract->precontractId")}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Propuesta">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
             {{--   <a href="{{route('reports.proposal', ['id' => $precontract->proposal->proposalId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Propuesta">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
              </a> --}}
            @endif
                @endforeach
                </tbody>
            </table>
        </div>
   

    </div>




@endsection
