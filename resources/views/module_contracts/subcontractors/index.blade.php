@extends('layouts.master')

@section('content')
<h3><b>SUBCONTRATISTAS</b></h3>
    <div class="row">
        <div class="col-xs-12 ">
          <div class="text-center">
{{-- 
   <div class="row ">
      <div class="col-xs-12">
      <form class="form-inline" action="{{Route('subcontractors.index')}}" method="GET">

         <div class="form-group">
           <label for="filteredOut"></label>
           <input type="text" class="form-control" name="filteredOut" id="filteredOut" placeholder="Filtrado" autocomplete="off">
         </div>

          <button type="submit" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Buscar">
                <span class="fa fa-search" aria-hidden="true"></span>
           </button>
        </form>
      </div>
    </div> --}}
     <br>

    @can('BAA')
            <a href="{{route('subcontractors.create')}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}}
            </a>
   @endcan
     <br>
                {{$subcontractors->render()}}
      <br>
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>#</th> 
                 <th>TIPO DNI</th> 
                 <th>DNI</th> 
                 <th>NOMBRE</th>
                 <th>TIPO</th>
                 <th>REPRESENTANTE</th>
                 <th>DIRECCION</th>
                 <th>TELEFONO</th>
                 <th>CORREO</th> 
                 <th>{{__('actions')}}</th> 
                 </th>
                </tr>
            </thead>
                <tbody>
                @php $acum=0; @endphp
                @foreach($subcontractors as $subcontractor)
                <tr>

                   <td>{{++$acum}}</td>
                   <td>{{$subcontractor->DNIType}}</td> 
                   <td>{{$subcontractor->DNI}}</td> 
                   <td>{{$subcontractor->name}}</td>
                   <td>{{$subcontractor->subcontType}}</td>
                   <td>{{$subcontractor->representative}}</td>
                   <td>{{$subcontractor->address}}</td>
                   <td>{{$subcontractor->mainPhone}}</td>
                   <td>{{$subcontractor->email}}</td> 

                   <td>
                   @can('BAB')  
                    <a href="{{route('subcontractors.edit', ['id' => $subcontractor->subcontId])}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top"  title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span>
                    </a>
                    <a href="{{route('subcontractors.payables', ['id' => $subcontractor->subcontId])}}" class="btn btn-success" data-toggle="tooltip" data-placement="top"  title="Cuentas por Pagar">
                        <span class="fa fa-edit" aria-hidden="true"></span>
                    </a> 
                    @endcan
                   <!--  @can('BAC') 
                       <a href="{{route('subcontractors.show', ['id' => $subcontractor->subcontId])}}" class="btn btn-danger">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a>
                    @endcan     -->
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
  
                {{$subcontractors->render()}}
  
        </div>
        </div>
    </div>



@endsection
{{-- <v-client-table :data="{{$subcontractors}}" :columns="['cltId','clientCode','clientName','clientPhone','clientEmail','contactTypeId','actions']" :options="{
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
     <a :href="'subcontractors/'+props.row.clientId+'/edit'" class="btn btn-primary">
        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
      </a>
    <a :href="'subcontractors/'+props.row.clientId" class="btn btn-danger">
        <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
       </a> 
  </div>     
</v-client-table> --}}