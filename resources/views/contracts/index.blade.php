@extends('layouts.master')

@section('content')


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

       <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">

    <li role="presentation" class="active"><a href="#Projects" aria-controls="Projects" role="tab" data-toggle="tab">PROYECTOS</a></li>
    <li role="presentation"><a href="#Services" aria-controls="Services" role="tab" data-toggle="tab">SERVICIOS</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="Projects">
   <br>
   <div class="row">
        <div class="col-xs-12 ">
            <div class="text-center">
        @can('BCA')
            <a href="{{ route('contracts.create',['contractType' => 'P']) }}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                 Agregar Proyecto
            </a>
        @endcan    
              <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
           </div>
           <br>
      </div>
    </div>

    <div class="table-responsive text-center">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>ID</th>
                 <th>N° {{__('contract')}}</th>
                 <th>COD. {{__('client')}}</th>
                 <th>{{__('address')}}</th>
                 <th>{{__('status')}}</th>
                 <th>{{__('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{$project->conId}} </td>
                    <td>{{$project->contractNumber}} </td>
                    <td>{{$project->client->clientCode}}   </td>
                    <td >{{$project->siteAddress}}   </td>
                    <td>{{$project->contractStatus}}   </td>
                    <td>
                  @can('BCE')   
                     <a href="{{route('contracts.changeStatus', ['id' => $project->contractId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('status')}}">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                    </a>
                  @endcan
                  @can('BCF')
                    <a href="{{route('contracts.staff', ['id' => $project->contractId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('staff')}}">
                     <span class="fa fa-users" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCG') 
                    <a href="{{route('contracts.files', ['id' => $project->contractId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Documentos">
                     <span class="fa fa-file" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCH')   
                     <a href="{{url("invoices?id=$project->contractId")}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Facturas">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCI')  
                     <a href="{{route('reports.contract', ['id' => $project->contractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="PDF">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a>
                    |
                  @endcan
                  @can('BCD')
                   <a href="{{route('contracts.details', ['id' => $project->contractId])}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('see')}}">
                        <span class="fa fa-search" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCC')
                    <a href="{{route('contracts.edit', ['id' => $project->contractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCB')
                    <a href="{{route('contracts.show', ['id' => $project->contractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a>
                  @endcan
                 </td>

                </tr>

                @endforeach
                </tbody>
            </table>

            {{$projects->render()}}
        </div>
    </div> <!--tab 1 final-->

    <div role="tabpanel" class="tab-pane" id="Services">
     <br>
     <div class="row">
        <div class="col-xs-12 ">
            <div class="text-center">
            <a href="{{ route('contracts.create',['contractType' => 'S']) }}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                  Agregar Servicio
            </a>
              <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('return')}}
              </a>
           </div>
           <br>
      </div>
    </div>

   <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
           <thead>
                <tr>
                 <th>ID</th>
                 <th>N° {{__('contract')}}</th>
                 <th>COD. {{__('client')}}</th>
                 <th>{{__('address')}}</th>
                 <th>{{__('status')}}</th>
                 <th>{{__('options')}}</th>
                </tr>
            </thead>
                <tbody>
                @foreach($services as $service)
                  <tr>
                     <td>{{$service->conId}} </td>
                    <td>{{$service->contractNumber}} </td>
                    <td>{{$service->client->clientCode}}   </td>
                    <td >{{$service->siteAddress}}   </td>
                    <td>{{$service->contractStatus}}   </td>
                    <td>
                  @can('BCE')   
                     <a href="{{route('contracts.changeStatus', ['id' => $service->contractId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('status')}}">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                    </a>
                  @endcan
                  @can('BCF')  
                    <a href="{{route('contracts.staff', ['id' => $service->contractId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('staff')}}">
                     <span class="fa fa-users" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCG')    
                    <a href="{{route('contracts.files', ['id' => $service->contractId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Documentos">
                     <span class="fa fa-file" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCH')    
                     <a href="{{url("/invoices?id=$service->contractId")}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Facturas">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCI')    
                   <a href="{{route('reports.contract', ['id' => $service->contractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="PDF">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a>
                    |
                  @endcan
                  @can('BCD')   
                   <a href="{{route('contracts.details', ['id' => $service->contractId])}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('see')}}">
                        <span class="fa fa-search" aria-hidden="true"></span> 
                   </a>
                  @endcan
                  @can('BCC')   
                    <a href="{{route('contracts.edit', ['id' => $service->contractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
                  @endcan
                  @can('BCB')   
                    <a href="{{route('contracts.show', ['id' => $service->contractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a>
                    @endcan 
                 </td>

                </tr>

                @endforeach
                </tbody>
            </table>
             {{$services->render()}}
        </div>



    </div> <!-- tab 2-->

</div>



@endsection



{{--                
<v-client-table :data="{{$projects}}" :columns="['conId','contractNumber','clientCode','siteAddress','contractStatus','actions']" :options="{
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