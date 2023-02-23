@extends('layouts.master')

@section('content')
<h3><b>USUARIOS</b></h3>
    <div class="row">
        <div class="col-xs-12 ">
          <div class="text-center">

 {{--   <div class="row ">
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
     <br> --}}

            <a href="{{route('users.create')}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}}
            </a>
{{--             <a href="{{route('roles.index')}}" class="btn btn-primary text-center" >
                <span class="fa fa-user-circle" aria-hidden="true"></span>
                   Roles
            </a> --}}
     <br> <br>
     
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>ID</th>
                 <th>{{__('name')}}</th> 
                 <th>USERNAME</th>
                 <th>{{__('email')}}</th>
                 {{-- <th>ROL</th> --}}
                 <th>{{__('actions')}}</th> 
                 </th>
                </tr>
            </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                   <td>{{$user->userId}}</td> 
                   <td>{{$user->fullName}}</td> 
                   <td>{{$user->userName}}</td>
                   <td>{{$user->email}}</td>
                   {{-- <td>{{$user->getRoleNames()}}</td> --}}
                   <td>
                    <a href="{{route('users.edit', ['id' => $user->userId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
                    </a>
                   <a href="{{route('users.show', ['id' => $user->userId])}}" class="btn btn-danger">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                    </a>
                      <a href="{{route('users.permissions', ['id' => $user->userId])}}" class="btn btn-warning text-center" >
                       <span class="fa fa-handshake" aria-hidden="true"></span> Permisos
                    </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
                {{-- {{$users->render()}} --}}
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