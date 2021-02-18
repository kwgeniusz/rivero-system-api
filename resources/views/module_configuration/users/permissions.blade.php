@extends('layouts.master')

@section('content')
<div class="create">
  <form class="formulario" action="{{Route('users.add.permissions',['id' => $user->userId])}}" method="POST">
  {{csrf_field()}}
    <div>
      <h3>Permisos de Usuario</h3>
      <div class="boxes">
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
        <div style="width: 100%; text-align: center; margin-bottom: 30px;">
          <button type="submit" class="submit">
            <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
          </button>
          <a href="{{route('users.index')}}" class="return">
            <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
          </a>
        </div>
        <div class="inputother boxes2">
          <label for="fullName"><u>USUARIO:</u></label>
          <input disabled type="text" class="input-label" id="fullName" name="fullName" value="{{$user->fullName}}">
        </div>
        <!--<div class="form-group col-xs-12 col-lg-7">
          <label>ROL:</u></label>
          @if($user->roles->count() > 0)
            {{$user->roles[0]->name}}
          @else
            NO TIENE
          @endif  
          <br>
          <a class="btn btn-info" href="#">Cambiar Rol</a>
        </div> -->
        <div class="inputother boxes2">
          <label for="changeCompany">Puede Cambiar de Pais?:</label>
          <select name="changeCompany" id="changeCompany" required="on">
            @if ($user->changeCompany == 'Y')
              <option value="Y" selected>Si</option>
              <option value="N" >No</option>
            @else
              <option value="Y">Si</option>
              <option value="N" selected>No</option>
            @endif
         </select>
        </div>  
        <div class="input-label boxes2">
          <label><u>OFICINA PREDETERMINADA:</u></label>
          <select-country-office pref-url="../../" country-id="{{$user->countryId}}" company-id="{{$user->companyId}}"></select-country-office>
        </div>    
        <!--{{$user->roles}}-->
        <!--{{$user->permissions}} -->
        {{-- <ol id="lista3">
          <li>List item</li>
          <li>List item</li>
          <li>List item
            <ol>
              <li>List sub item
                <ol>
                  <li>List item</li>
                  <li>List item</li>
                </ol>   
              </li>
              <li>List sub item</li>
              <li>List sub item</li>
            </ol>
          </li>
          <li>List item</li>
          <li>List item</li> 
        </ol> --}}
        <div class="form-group col-xs-7">
          <label ><u> PERMISOS:</u></label>
          <br>
          @foreach($permissions as $permission)
            <label for="permission_{{$permission->id}}" class="col-xs-12 btn " >
              <div class="col-xs-6 text-left">
                @php 
                if(strlen($permission->name) == 1)
                    echo "<b>$permission->description</b>"; 
                if(strlen($permission->name) == 2)
                    echo "<u>$permission->description</u>"; 
                if(strlen($permission->name) > 2)
                    echo "<b>$permission->description</b>"; 
                @endphp
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
@endsection
@push('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endpush