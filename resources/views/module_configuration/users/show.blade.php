@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-lg-9 col-lg-offset-1">
<div class="panel panel-danger ">
    <div class="panel-heading text-center"> <h3><b>¿Desea Eliminar Este Usuario?</b></h3></div>
    <div class="panel-body">


        <form class="form" action="{{Route('users.destroy',['id' => $user[0]->userId] )}}" method="POST">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}


{{--  <div class="row">
          <div class="form-group col-lg-4">
            <label for="changeOffice">PUEDE CAMBIAR DE OFICINA?</label>
            <select disabled="on" class="form-control" name="changeOffice" id="changeOffice">
              @if($user[0]->changeOffice == 'Y')
                      <option value="Y" selected="on"> YES </option>
                      <option value="N"> NO </option>

              @else
                      <option value="Y"> YES </option>
                      <option value="N" selected="on"> NO </option>
              @endif
            </select>
          </div>
       </div>
 --}}
   <div class="row"> 
              <div class="form-group col-lg-7">
                <label for="fullName">NOMBRE Y APELLIDOS</label>
                <input  disabled="on" type="text" class="form-control" id="fullName" name="fullName" value="{{ $user[0]->fullName }}" >
              </div>
   </div>      
    <div class="row"> 
              <div class="form-group col-lg-7">
                <label for="userName">USERNAME</label>
                <input  disabled="on" type="text" class="form-control" id="userName" name="userName" value="{{ $user[0]->userName }}" >
              </div>
   </div>         
{{--     <div class="row"> 
              <div class="form-group col-lg-6">
                <label for="password">NUEVA CONTRASEÑA</label>
                <input type="password" class="form-control" id="password" name="password" value="{{ $user[0]->password }}">
              </div>
              <div class="row"></div>
                <div class="form-group col-lg-6">
                <label for="password_confirmation">NUEVA CONFIRMAR CONTRASEÑA</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ }}">
              </div>
     </div> --}}
    <div class="row"> 
              <div class="form-group col-lg-7">
                <label for="email">EMAIL</label>
                <input disabled="on" type="email" class="form-control" id="email" name="email" value="{{ $user[0]->email }}">
              </div>
   </div>       

            <div class="text-center">
              <button type="submit" class="btn btn-danger">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
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
