@extends('layouts.master')

@section('content')
<h3><b>ROLES</b></h3>
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
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

            <a href="{{route('roles.create')}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}}
            </a>
     <br> <br>
     
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>ID</th>
                 <th>{{__('name')}}</th> 
                 <th>{{__('actions')}}</th> 
                 </th>
                </tr>
            </thead>
                <tbody>
                @foreach($roles as $rol)
                <tr>
                   <td>{{$rol->id}}</td> 
                   <td>{{$rol->name}}</td> 
                   <td>
                    <a href="{{route('roles.edit', ['id' => $rol->id])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
                    </a>
                   <a href="{{route('roles.show', ['id' => $rol->id])}}" class="btn btn-danger">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                    </a>
                      <a href="{{route('permissions.index')}}" class="btn btn-warning text-center" >
                <span class="fa fa-handshake" aria-hidden="true"></span>
                   Permisos
            </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
                {{-- {{$roles->render()}} --}}
        </div>
  
             <a href="{{route('users.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
        </div>
    </div>



@endsection