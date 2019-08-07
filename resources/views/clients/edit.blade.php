@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-success col-xs-7">
    <div class="panel-heading"> <h3><b>{{__('edit_client')}}</b></h3></div>
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

        <form class="form" action="{{Route('clients.update',['id' => $client[0]->clientId])}}" method="POST">
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
            <input type="hidden" name="countryId" value="{{$client[0]->countryId}}">
            
              <div class="form-group">
                <label for="clientName">{{__('names_and_surnames')}}</label>
                <input type="text" class="form-control" id="clientName" name="clientName" value="{{$client[0]->clientName}}" placeholder="Nombres y Apellidos">
              </div>

              <div class="form-group">
                <label for="clientAddress">{{__('address')}}</label>
                <input type="text" class="form-control" id="clientAddress" name="clientAddress" value="{{$client[0]->clientAddress}}" placeholder="Direccion">
              </div>
  <div class="row">
          <div class="form-group col-xs-4">
            <label for="contactTypeId">TIPO DE CONTACTO</label>
            <select class="form-control" name="contactTypeId" id="contactTypeId">
                @foreach($contactTypes as $contactType)
                   @if($contactType->contactTypeId == $client[0]->contactTypeId)
                      <option value="{{$contactType->contactTypeId}}" selected > {{$contactType->contactTypeName}} </option>
                   @else
                       <option value="{{$contactType->contactTypeId}}" > {{$contactType->contactTypeName}} </option>
                   @endif
                @endforeach
            </select>
          </div>
 </div>
              <div class="col-xs-6">
              <div class="form-group">
                <label for="clientPhone">{{__('phone')}}</label>
                <input type="text" class="form-control" id="clientPhone" name="clientPhone" value="{{$client[0]->clientPhone}}" placeholder="000 000 0000" title="formato: 000 000 0000">
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label for="clientEmail">{{__('email')}}</label>
                <input type="email" class="form-control" id="clientEmail" name="clientEmail" value="{{$client[0]->clientEmail}}" placeholder="Correo">
              </div>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('save')}}
              </button>
              <a href="{{route('clients.index')}}" class="btn btn-warning">
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
