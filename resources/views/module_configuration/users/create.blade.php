@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-success col-xs-7">
    <div class="panel-heading"> <h3><b>Nuevo Usuario</b></h3></div>
    <div class="panel-body">
      <div class="row ">
          <div class="col-xs-12 ">

        @if ($errors->any())
          <div class="alert alert-danger">
              <h4>Errores:</h4>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

        <form class="form" action="{{Route('users.store')}}" method="POST">
        {{csrf_field()}}
 <div class="row">
      <select-country-office pref-url="./../"></select-country-office>
</div>
      <div class="row">
          <div class="form-group col-xs-4">
            <label for="rol">Roles</label>
            <select class="form-control" name="rol" id="rol">
                @foreach($roles as $rol)
                      <option value="{{$rol->id}}" > {{$rol->name}} </option>
                @endforeach
            </select>
          </div>
       </div>
<div class="row">      
       <search-client url="e"></search-client>
</div>       
   <div class="row"> 
              <div class="form-group col-xs-7">
                <label for="clientPhone">Nombre y Apellido</label>
                <input type="text" class="form-control" id="clientPhone" name="clientPhone" value="{{ old('clientPhone') }}"  title="formato: 000 000 0000">
              </div>
   </div>      
    <div class="row"> 
              <div class="form-group col-xs-7">
                <label for="clientPhone">User Name</label>
                <input type="text" class="form-control" id="clientPhone" name="clientPhone" value="{{ old('clientPhone') }}"  title="formato: 000 000 0000">
              </div>
   </div>       
    <div class="row"> 
              <div class="form-group col-xs-3">
                <label for="clientPhone">Contraseña Automatica</label>
                <select class="form-control" name="a">
                  <option value="Y">Si</option>
                  <option value="N">No</option>
                </select>

              </div>
              <div class="form-group col-xs-6">
                <label for="clientEmail">Contraseña</label>
                <input type="email" class="form-control" id="clientEmail" name="clientEmail" value="{{ old('username') }}">
              </div>
     </div>

        <div class="form-group">
                <div class="row">
                    <label for="" class="col-md-12">Permisos</label>
                    @foreach($permissions as $key => $permission)
                        <div class="col-md-6">
                            <label for="permission_{{$permission->id}}" class="checkbox-inline">
                                <input @if($permission->checked == 1) checked @endif type="checkbox" id="permission_{{$permission->id}}" name="permissions[]" value="{{$permission->id}}">{{$permission->name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
              </button>
              <a href="{{route('users.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
@endsection
