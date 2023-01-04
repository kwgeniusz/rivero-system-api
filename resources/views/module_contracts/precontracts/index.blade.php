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
        @can('BBA')
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
                 <th>CLIENTE</th>   
                 <th>{{__('address')}}  / NOMBRE DEL PROYECTO</th>
                 <!-- <th>BUILDING CODE</th> -->
                 <th>DESCRIPCION</th>
                 <th>USO</th>
                 <th>TIPO</th>
                 <th>FECHA DE CREACION</th>
                 <th>REGISTRADO POR</th>
                 <th>{{__('options')}}</th>
                </tr>
            </thead>
                <tbody>
                 @php $acum=0; @endphp
                @foreach($precontracts as $precontract)
                <tr>
                   <td>{{++$acum}}</td>
                    <td>{{$precontract->preId}}
                      <comments-precontract pref-url="" precontract-id="{{$precontract->precontractId}}"/>
                     </td>
                    <td>{{$precontract->client->clientCode}} 

                     </td>
                    <td>
                     <modal-client-details pref-url="/" client-id="{{$precontract->client->clientId}}" company-name="{{$precontract->client->companyName}}" client-name="{{$precontract->client->clientName}}"></modal-client-details>
                      Tlf: {{$precontract->client->businessPhone}}   <br>
                      Correo: {{$precontract->client->mainEmail}} <br>
                      Idioma: {{$precontract->client->clientLanguages}}
                      
                    </td>  
                    <td >{{$precontract->siteAddress}}
                  <br>
                        @if($precontract->projectName) 
                         ( {{$precontract->projectName}} )
                        @endif  </td>
                <!-- <td>
                @if($precontract->buildingCodeId)      
                 {{$precontract->buildingCode->buildingCodeName}}  
                @endif 
                </td> -->
                    <td >
                       @foreach($precontract->proposal as $pd)
                       - {{$pd->projectDescription->projectDescriptionName}}<br>
                        @endforeach
                     </td>     
                    <td >
                      @if($precontract->projectUseId) 
                      {{$precontract->projectUse->projectUseName}} 
                    @endif  
                       </td>     
                    <td >{{$precontract->contractType}}   </td>
                    <td >{{$precontract->precontractDate}}   </td>
                    <td >
                    @if($precontract->user != null){{$precontract->user->fullName}} @endif  
                     </td>
                    <td>
        @if($precontract->contractId == null)
              @can('BCF')
               <modal-convert-precontract pref-url="./" precontract-id="{{$precontract->precontractId}}"></modal-convert-precontract>
              @endcan      
              @can('BC')
                <a href="{{route('precontractsProposals.index', ['id' => $precontract->precontractId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Propuesta">
                    <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                </a>
                 @endcan      
               <!-- @can('BBB')      -->
                    <a href="{{route('precontracts.edit', ['id' => $precontract->precontractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
               <!-- @endcan   -->

              @can('BBC')      
                    <a href="{{route('precontracts.show', ['id' => $precontract->precontractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a>
              @endcan   
                  <a href="{{route('precontractsFile.index', ['id' => $precontract->precontractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Documentos">
                           <span class="fa fa-file" aria-hidden="true"></span> 
                       </a>  
        @else
             @can('BC')  
              <a class="btn btn-primary btn-sm" href="{{url("invoices?id=$precontract->contractId")}}">Ir a Contrato</a>

                <!-- <a href="{{route('precontractsBudgets.index', ['id' => $precontract->precontractId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Presupuesto">
                    <i class="fa fa-book"></i>
                </a> -->

                <a href="{{route('precontractsProposals.index', ['id' => $precontract->precontractId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Propuesta">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                </a>
              @endcan      
        @endif
               </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
   

    </div>




@endsection
