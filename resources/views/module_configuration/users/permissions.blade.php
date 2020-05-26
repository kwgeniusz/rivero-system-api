@extends('layouts.master')

@section('content')
<div class="col-xs-10 col-xs-offset-1">
<div class="panel panel-success">
    <div class="panel-heading text-center"> <h3><b>Permisos de Usuario</b></h3></div>
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

    <form class="form" action="{{Route('users.add.permissions',['id' => $user->userId])}}" method="POST">
        {{csrf_field()}}

 <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
              </button>

              <a href="{{route('users.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
</div>

   <div class="row"> 

         <div class="form-group col-xs-12 col-lg-7">
           <label for="fullName"><u>USUARIO:</u></label>
           <input disabled type="text" class="form-control" id="fullName" name="fullName" value="{{$user->fullName}}">
         </div>

<!--         <div class="form-group col-xs-12 col-lg-7">
           <label>ROL:</u></label>
           @if($user->roles->count() > 0)
             {{$user->roles[0]->name}}
           @else
             NO TIENE
           @endif  
           <br>
           <a class="btn btn-info" href="#">Cambiar Rol</a>
         </div> -->

        <div class="form-group col-xs-12 col-lg-7">
           <label><u>OFICINA PREDETERMINADA:</u></label>
         </div>

        <select-country-office pref-url="../../" country-id="{{$user->countryId}}" office-id="{{$user->officeId}}"></select-country-office>

         <div class="form-group col-xs-6">
            <label for="changeOffice">Puede Cambiar de Pais?:</label>
          <select  class="form-control" name="changeOffice" id="changeOffice" required="on">
                   @if ($user->changeOffice == 'Y')
                     <option value="Y" selected>Si</option>
                     <option value="N" >No</option>
                  @else
                     <option value="Y">Si</option>
                     <option value="N" selected>No</option>
                  @endif
         </select>
        </div>  

   </div>      
<!--{{$user->roles}}-->
<!--{{$user->permissions}} -->

     <div class="row">
        <div class="form-group col-xs-7">
                    <label ><u> PERMISOS:</u></label>
                    <br>

                    @foreach($permissions as $permission)
                       <label for="permission_{{$permission->id}}" class="col-xs-12 btn " >
                           <div class="col-xs-6 text-left">
                            {{$permission->description}}  {{--  ({{$permission->name}}) --}} 
                           </div>
                          <div class="col-xs-6">
                            <input            
                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }} 
                        @if($user->roles->count() > 0)
                    {{ $user->roles[0]->permissions->contains($permission->id) ? 'disabled' : '' }} 
                        @endif
                             type="checkbox" 
                             id="permission_{{$permission->id}}" 
                             name="permissions[]" 
                             value="{{$permission->id}}">
                           </div>
                        </label>     
                    @endforeach

  
                </div>
            </div>

            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
@endsection
