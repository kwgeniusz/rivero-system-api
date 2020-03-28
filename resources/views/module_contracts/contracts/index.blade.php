@extends('layouts.master')

@section('content')

<dynamic-table></dynamic-table>
  <h3><b>{{__('contracts')}}</b></h3>
 <div class="row ">
      <div class="col-xs-12 text-center">
      <form class="form-inline" action="{{Route('contracts.index')}}" method="GET">

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
            <div class="text-center">
{{--         @can('BBA')
            <a href="{{ route('contracts.create') }}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                 Agregar Contrato
            </a>
        @endcan     --}}
              <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
              <br><br>
            {{$contracts->render()}}
           </div>
          
      </div>
    </div>

    <div class="table-responsive text-center">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>ID</th>
                 <th>N° {{__('contract')}}</th>
                 <th>COD. {{__('client')}}</th>
                 {{-- <th>{{__('name')}}</th>    --}}
                 <th>{{__('address')}}</th>
                 <th>BUILDING CODE</th>
                 <th>DESCRIPTION</th>
                 <th>USO</th>
                 <th>TIPO</th>
                 <th>{{__('STATUS')}}</th>
                 <th>{{__('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contracts as $contract)
                <tr>
                    <td>{{$contract->conId}} </td>
                    <td>{{$contract->contractNumber}} </td>
                    <td>{{$contract->client->clientCode}}</p></td>
                    {{-- <td>{{$contract->client->clientName}}   </td>   --}}
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
                  @can('BCE')   
                     <a href="{{route('contracts.changeStatus', ['id' => $contract->contractId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('status')}}">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                    </a>
                  @endcan
                  @can('BCF')
                    <a href="{{route('contracts.staff', ['id' => $contract->contractId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('staff')}}">
                     <span class="fa fa-users" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCG') 
                    <a href="{{route('contracts.files', ['id' => $contract->contractId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Documentos">
                     <span class="fa fa-file" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCH')   
                     <a href="{{url("invoices?id=$contract->contractId")}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Facturas">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCI')  
                     <a href="{{route('reports.contract', ['id' => $contract->contractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a>
                    |
                  @endcan
                  @can('BCD')
                   <a href="{{route('contracts.details', ['id' => $contract->contractId])}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('see')}}">
                        <span class="fa fa-search" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCC')
                    <a href="{{route('contracts.edit', ['id' => $contract->contractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCB')
                    <a href="{{route('contracts.show', ['id' => $contract->contractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a>
                  @endcan
                 </td>

                </tr>

                @endforeach
                </tbody>
            </table>
            {{$contracts->render()}}

    
        </div>
  
</div>



@endsection



{{--                
<v-client-table :data="{{$contracts}}" :columns="['conId','contractNumber','clientCode','siteAddress','contractStatus','actions']" :options="{
           headings: {
            conId: 'ID',
            contractNumber: 'N° {{__('contract')}}',
            clientCode: '{{__('client')}}',
            siteAddress: '{{__('address')}}',
            contractStatus: '{{__('status')}}',
            actions: '{{__('options')}}'
           },
            sortable: ['contractNumber'],
            filterable: ['contractNumber'],
            // EDITABLE TEXT OPTIONS:
            texts: {
                count: 'Mostrar del {from} al {to} de {count} registros|{count} registros|One record',
                first: 'Primero',
                last: 'Ultimo',
                filter: 'Filtrado:',
                filterPlaceholder: 'Buscar',
                limit: 'Records:',
                page: 'Pagina:',
                noResults: 'No Se encontraron Registros',
                filterBy: 'Filter by {column}',
                loading: 'Cargando...',
                defaultOption: 'Select {column}',
                columns: 'Columns',
                  limit:'Limites:',
            },
        }">
  <div slot="actions" slot-scope="props">
     <a :href="'clients/'+props.row.contractId+'/edit'" class="btn btn-primary">
        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
      </a>
    <a :href="'clients/'+props.row.contractId" class="btn btn-danger">
        <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
       </a> 
  </div>     
</v-client-table> --}}