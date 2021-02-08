@extends('layouts.master')

@section('content')
<div class="create">
  <form  class="formulario" action="{{Route('clients.update',['id' => $client[0]->clientId])}}" method="POST">
    <div>
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
        {{method_field('PUT')}}

    {{--        <div class="row">
          <div class="form-group col-xs-4">
            <label for="countryId">{{__('country')}}</label>
            <select class="form-control" name="countryId" id="countryId">
                @foreach($countrys as $country)
                   @if($country->countryId == $client[0]->countryId)
                      <option value="{{$country->countryId}}" selected > {{$country->countryName}} </option>
                   @else
                       <option value="{{$country->countryId}}" > {{$country->countryName}} </option>
                   @endif
                @endforeach

            </select>
          </div>
         </div>
 --}}
        <div class="inputother boxes2">
          <label for="clientCode"><i class="far fa-id-card"></i> CODIGO</label>
          <input type="text" style="cursor: no-drop" class="input-label" id="clientCode" name="clientCode" value="{{$client[0]->clientCode}}" disabled="on">
        </div>
        <div class="inputother boxes2">
                <label for="clientName"><i class="fas fa-user-friends"></i> {{__('names_and_surnames')}}</label>
                <input type="text" class="input-label" id="clientName" name="clientName" value="{{$client[0]->clientName}}" placeholder="NOMBRE Y APELLIDO / EMPRESA">
              </div>
        <div class="inputother boxes2">
          <label for="clientAddress"><i class="fas fa-map-marked-alt"></i> {{__('address')}}</label>
          <input type="text" class="input-label" id="clientAddress" name="clientAddress" value="{{$client[0]->clientAddress}}" placeholder="5924 Azalea Ln Dallas, TX 75230">
        </div>
        <div class="inputother boxes2">
          <label for="contactTypeId"><i class="fas fa-tty"></i> ¿COMO NOS CONTACTO?</label>
          <select name="contactTypeId" id="contactTypeId">
                @foreach($contactTypes as $contactType)
                   @if($contactType->contactTypeId == $client[0]->contactTypeId)
                      <option value="{{$contactType->contactTypeId}}" selected > {{$contactType->contactTypeName}} </option>
                   @else
                       <option value="{{$contactType->contactTypeId}}" > {{$contactType->contactTypeName}} </option>
                   @endif
                @endforeach
            </select>
        </div>
        <div class="inputother boxes2">
          <label for="clientPhone"><i class="fas fa-phone-square"></i> {{__('phone')}}</label>
          <input type="text" class="input-label" id="clientPhone" name="clientPhone" value="{{$client[0]->clientPhone}}" placeholder="(000) 000 0000"  title="formato: (000) 000 0000">
        </div>
        <div class="inputother boxes2">  
          <label for="clientEmail"><i class="fas fa-at"></i> {{__('email')}}</label>
          <input type="email" class="input-label" id="clientEmail" name="clientEmail" value="{{$client[0]->clientEmail}}" placeholder="CORREO DE CONTACTO">
        </div>
      </div>
    </div>
    <div style="width: 100%; text-align: center;">
      <button type="submit" class="submit">
        <span class="fa fa-check" aria-hidden="true"></span>  {{__('update')}}
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
