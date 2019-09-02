@extends('layouts.master')

@section('content')
<h3><b>{{__('client')}}</b></h3>
    <div class="row">
        <div class="col-xs-12 ">
          <div class="text-center">

   <div class="row ">
      <div class="col-xs-12">
      <form class="form-inline" action="{{Route('clients.index')}}" method="GET">

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

            <a href="{{route('clients.create')}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}}
            </a>
     <br> <br>
     
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>ID</th> 
                 <th>CODIGO</th>
                 <th>{{__('name')}}</th>
                 <th>{{__('phone')}}</th>
                 <th>{{__('email')}}</th>
                 <th>CONTACTO</th> 
                 <th>{{__('actions')}}</th> 
                 </th>
                </tr>
            </thead>
                <tbody>
                @foreach($clients as $client)
                <tr>
                   <td>{{$client->cltId}}</td> 
                   <td>{{$client->clientCode}}</td>
                   <td>{{$client->clientName}}</td>
                   <td>{{$client->clientPhone}}</td>
                   <td>{{$client->clientEmail}}</td>
                   <td>{{$client->contactType->contactTypeName}}</td> 
                   <td><a href="{{route('clients.edit', ['id' => $client->clientId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
                    </a>
                       <a href="{{route('clients.show', ['id' => $client->clientId])}}" class="btn btn-danger">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
                {{$clients->render()}}
        </div>
  
             <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
        </div>
    </div>



@endsection
{{-- <v-client-table :data="{{$clients}}" :columns="['cltId','clientCode','clientName','clientPhone','clientEmail','contactTypeId','actions']" :options="{
           headings: {
            cltId: 'ID',
            clientCode: 'CODIGO',
            clientName: '{{__('name')}}',
            clientPhone: '{{__('phone')}}',
            clientEmail: '{{__('email')}}',
            contactTypeId: 'CONTACTO',
            actions: '{{__('actions')}}'
           },
            sortable: ['clientName'],
            filterable: ['clientName'],
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
     <a :href="'clients/'+props.row.clientId+'/edit'" class="btn btn-primary">
        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
      </a>
    <a :href="'clients/'+props.row.clientId" class="btn btn-danger">
        <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
       </a> 
  </div>     
</v-client-table> --}}