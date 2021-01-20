@extends('layouts.master')

@section('content')

{{-- <dynamic-table></dynamic-table> --}}
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
                <tr class="bg-info">
                 <th>#</th>
                 <th>{{__('contract_number')}}</th>
                 {{-- <th>COD. {{__('client')}}</th> --}}
                 <th>{{__('name')}}</th>   
                 <th>{{__('address')}} / NOMBRE DEL PROYECTO</th>
                 <th>IBC</th>
                 <th>DESCRIPCION</th>
                 <th>USO</th>
                 <th>TIPO</th>
                 <th>{{__('STATUS')}}</th>
                </tr>
            </thead>
            <tbody>
              @php $acum=0; @endphp
                @foreach($contracts as $contract)
                <tr>
                   <td>{{++$acum}}</td>
                  <td>
                <modal-switch-contract pref-url="/" contract-id="{{$contract->contractId}}" contract-number="{{$contract->contractNumber}}"></modal-switch-contract>
        @can('BDE')
                <comments-contract pref-url="" contract-id="{{$contract->contractId}}" contract-number="{{$contract->contractNumber}}"></comments-contract>
         @endcan
                     </td>
{{--                     <td>{{$contract->client->clientCode}}</p></td> --}}
                    <td>
                <modal-client-details pref-url="/" client-id="{{$contract->client->clientId}}" client-name="{{$contract->client->clientName}}"></modal-client-details>

                     </td>  
                       <td>{{$contract->propertyNumber}}
                        {{$contract->streetName}}
                        {{$contract->streetType}}
                        {{$contract->suiteNumber}}
                        {{$contract->city}}
                        {{$contract->state}}
                        {{$contract->zipCode}}  
                        <br> 
                      @if($contract->projectName) 
                       ( {{$contract->projectName}} )
                      @endif 
                    </td>
                    <td>{{$contract->buildingCode->buildingCodeName}}   </td>
                    <td> 
                     @foreach($contract->invoice as $inv)
                       - {{$inv->projectDescription->projectDescriptionName}}<br>
                        @endforeach 
                        </td>
                    <td>{{$contract->projectUse->projectUseName}}   </td>
                    <td>{{$contract->contractType}}   </td>
                    <td data-toggle="tooltip" data-placement="top" title="{{$contract->contractStatusR[0]->contStatusName}}"
                   @if($contract->contractStatus == App\Contract::VACANT)
                   style="background-color: #3c8ddc;color:white;" 
                   @elseif($contract->contractStatus == App\Contract::STARTED)
                    style="background-color: #2ab25b;color:white;" 
                    @elseif($contract->contractStatus == App\Contract::READY_BUT_PENDING_PAYABLE)
                    style="background-color: #cbb956;color:white;" 
                   @elseif($contract->contractStatus == App\Contract::PROCESSING_PERMIT)
                    style="background-color: #f39c12;color:white;" 
                    @elseif($contract->contractStatus == App\Contract::WAITING_CLIENT)
                    style="background-color: red;color:white;"  
                   @elseif($contract->contractStatus == App\Contract::DOWNLOADING_FILES)
                    style="background-color: #666666; color:white;"    
                   @elseif($contract->contractStatus == App\Contract::SENT_TO_OFFICE)
                    style="background-color: #5dc1b9; color:white;"    
                   @endif
                   >
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