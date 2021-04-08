@extends('layouts.master')

@section('content')

<main-client/>
<!--    <div class="row ">
    <div class="col-xs-3">
      
    </div>

      <div class="col-xs-6">
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

      <div class="col-xs-3">
          <a href="{{route('reports.clients')}}" class="btn btn-danger btn-sm text-right">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> Imprimir Clientes de la Corporacion
           </a>
            <br> 
         @can('FE')
           <a class="btn btn-info btn-sm" href="{{route('contactTypes.index')}}">¿Como nos Contacto?</a>
          @endcan
      </div>
    </div>
     <br> -->



@endsection
