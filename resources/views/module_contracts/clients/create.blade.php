@extends('layouts.master')

@section('content')
<div class="create">
  <form  class="formulario" action="{{Route('clients.store')}}" method="POST">
    <h3><i class="fas fa-user-tie"></i> {{__('new_client')}}</h3>
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
        {{csrf_field()}}
        {{--       <div class="form-group col-xs-4">
                <label for="countryId">{{__('country')}}</label>
                <select class="form-control" name="countryId" id="countryId">
                    @foreach($countrys as $country)
                          <option value="{{$country->countryId}}" > {{$country->countryName}} </option>
                    @endforeach
                </select>
              </div> --}}
        <div class="inputother birthday">
          <label for="clientNumberFormat"><i class="far fa-id-card"></i> CODIGO</label>
          <input type="text" style="cursor: no-drop" class="input-label" id="clientNumberFormat" name="clientNumberFormat" value="{{ $clientNumberFormat}}" disabled="on">
        </div>
        <div class="inputother birthday">
                <label for="clientName"><i class="fas fa-user-friends"></i> NOMBRE Y APELLIDO / EMPRESA</label>
                <input type="text" class="input-label" id="clientName" name="clientName" value="{{ old('clientName') }}" placeholder="NOMBRE Y APELLIDO / EMPRESA">
              </div>
        <div class="inputother birthday">
          <label for="clientAddress"><i class="fas fa-map-marked-alt"></i> {{__('address')}}</label>
          <input type="text" class="input-label" id="clientAddress" name="clientAddress" value="{{ old('clientAddress') }}" placeholder="5924 Azalea Ln Dallas, TX 75230">
        </div>
        <div class="inputother birthday">
          <label for="contactTypeId"><i class="fas fa-tty"></i> ¿COMO NOS CONTACTO?</label>
          <select name="contactTypeId" id="contactTypeId">
              @foreach($contactTypes as $contactType)
                    <option value="{{$contactType->contactTypeId}}" > {{$contactType->contactTypeName}} </option>
              @endforeach
          </select>
        </div>
        <div class="inputother birthday">
          <label for="clientPhone"><i class="fas fa-phone-square"></i> {{__('phone')}}</label>
          <input type="text" class="input-label" id="clientPhone" name="clientPhone" value="{{ old('clientPhone') }}" placeholder="(000) 000 0000"  title="formato: (000) 000 0000">
        </div>
        <div class="inputother birthday">  
          <label for="clientEmail"><i class="fas fa-at"></i> {{__('email')}}</label>
          <input type="email" class="input-label" id="clientEmail" name="clientEmail" value="{{ old('username') }}" placeholder="CORREO DE CONTACTO">
        </div>

      </div>
    </div>

    <div style="width: 100%; text-align: center;">
      <button type="submit" class="submit">
        <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
      </button>
      <a href="{{route('clients.index')}}" class="return">
          <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
      </a>

    </div>
  </form>
</div>
@endsection
@push('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endpush