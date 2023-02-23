@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-lg-9 col-lg-offset-1">
<div class="panel panel-success">
    <div class="panel-heading text-center"> <h3><b>Nuevo Usuario</b></h3></div>
    <div class="panel-body">


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
          <div class="form-group col-lg-4">
            <label for="changeCompany">PUEDE CAMBIAR DE OFICINA?</label>
            <select class="form-control" name="changeCompany" id="changeCompany">
                      <option value="Y"> YES </option>
                      <option value="N"> NO </option>
            </select>
          </div>
       </div>

   <div class="row"> 
              <div class="form-group col-lg-7">
                <label for="fullName">NOMBRE Y APELLIDOS</label>
                <input type="text" class="form-control" id="fullName" name="fullName" value="{{ old('fullName') }}" >
              </div>
   </div>      
    <div class="row"> 
              <div class="form-group col-lg-7">
                <label for="userName">USERNAME</label>
                <input type="text" class="form-control" id="userName" name="userName" value="{{ old('userName') }}" >
              </div>
   </div>       
{{--       <div class="row">
          <div class="form-group col-lg-4">
            <label for="rol">Roles</label>
            <select class="form-control" name="rol" id="rol">
                @foreach($roles as $rol)
                      <option value="{{$rol->id}}" > {{$rol->name}} </option>
                @endforeach
            </select>
          </div>
       </div> --}}
{{-- <div class="row">      
       <search-client url="e"></search-client>
</div>    --}}    
    <div class="row"> 
{{--               <div class="form-group col-lg-4">
                <label for="clientPhone">Contraseña Automatica</label>
                <select class="form-control" name="a">
                  <option value="Y">Si</option>
                  <option value="N">No</option>
                </select>

              </div> --}}
              <div class="form-group col-lg-6">
                <label for="password">CONTRASEÑA</label>
                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
              </div>
              <div class="row"></div>
                <div class="form-group col-lg-6">
                <label for="password_confirmation">CONFIRMAR CONTRASEÑA</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}">
              </div>
     </div>
    <div class="row"> 
              <div class="form-group col-lg-7">
                <label for="email">EMAIL</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
              </div>
   </div>       

            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
              </button>
              <a href="{{route('users.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
              
          </form>
        </div>

      </div>
    </div>
  </div>
@endsection
