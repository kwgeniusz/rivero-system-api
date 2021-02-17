@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-lg-9 col-lg-offset-1">
<div class="panel panel-success">
    <div class="panel-heading text-center"> <h3><b>Editar Usuario</b></h3></div>
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

        <form class="form" action="{{Route('users.update',['id' => $user[0]->userId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}
 <div class="row">
      <select-country-office pref-url="../../" country-id="{{$user[0]->countryId}}" company-id="{{$user[0]->companyId}}"></select-country-office>
</div>

 <div class="row">
          <div class="form-group col-xs-4">
            <label for="changeCompany">PUEDE CAMBIAR DE OFICINA?</label>
            <select class="form-control" name="changeCompany" id="changeCompany">
              @if($user[0]->changeCompany == 'Y')
                      <option value="Y" selected="on"> YES </option>
                      <option value="N"> NO </option>

              @else
                      <option value="Y"> YES </option>
                      <option value="N" selected="on"> NO </option>
              @endif
            </select>
          </div>
       </div>

   <div class="row"> 
              <div class="form-group col-xs-7">
                <label for="fullName">NOMBRE Y APELLIDOS</label>
                <input type="text" class="form-control" id="fullName" name="fullName" value="{{ $user[0]->fullName }}" >
              </div>
   </div>      
    <div class="row"> 
              <div class="form-group col-xs-7">
                <label for="userName">USERNAME</label>
                <input type="text" class="form-control" id="userName" name="userName" value="{{ $user[0]->userName }}" >
              </div>
   </div>         
{{--     <div class="row"> 
              <div class="form-group col-xs-6">
                <label for="password">NUEVA CONTRASEÑA</label>
                <input type="password" class="form-control" id="password" name="password" value="{{ $user[0]->password }}">
              </div>
              <div class="row"></div>
                <div class="form-group col-xs-6">
                <label for="password_confirmation">NUEVA CONFIRMAR CONTRASEÑA</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ }}">
              </div>
     </div> --}}
    <div class="row"> 
              <div class="form-group col-xs-7">
                <label for="email">EMAIL</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user[0]->email }}">
              </div>
   </div>       


            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('update')}}
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
