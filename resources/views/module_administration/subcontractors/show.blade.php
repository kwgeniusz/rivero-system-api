@extends('layouts.master')

@section('content')
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-danger col-xs-7">
    <div class="panel-heading"> <h3><b>{{__('are_you_sure_to_eliminate_this_client?')}}</b></h3></div>
    <div class="panel-body">
      <div class="row ">
          <div class="col-xs-12 ">


        <form class="form form-prevent-multiple-submits" action="{{Route('clients.destroy',['id' => $client[0]->clientId] )}}" method="POST">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}

           <div class="form-group">
                <label for="countryId">{{__('country')}}</label>
                <input type="text" class="form-control" id="countryId" name="countryId" value="{{$client[0]->country->countryName}}" placeholder="Nombres y Apellidos" disabled>
              </div>

               <div class="form-group">
                <label for="clientCode">CODIGO</label>
                <input type="text" class="form-control" id="clientCode" name="clientCode" value="{{$client[0]->clientCode}}" placeholder="Nombres y Apellidos" disabled>
              </div>

              <div class="form-group">
                <label for="clientName">{{__('names_and_surnames')}}</label>
                <input type="text" class="form-control" id="clientName" name="clientName" value="{{$client[0]->clientName}}" placeholder="Nombres y Apellidos" disabled>
              </div>

              <div class="form-group">
                <label for="clientAddress">{{__('address')}}</label>
                <input type="text" class="form-control" id="clientAddress" name="clientAddress" value="{{$client[0]->clientAddress}}" placeholder="Direccion" disabled>
              </div>

              <div class="form-group">
                <label for="contactType">TIPO DE CONTACTO</label>
                <input type="text" class="form-control" id="contactType" name="contactType" value="{{$client[0]->contactType->contactTypeName}}" placeholder="Direccion" disabled>
              </div>

              <div class="col-xs-6">
              <div class="form-group">
                <label for="clientPhone">{{__('phone')}}</label>
                <input type="text" class="form-control" id="clientPhone" name="clientPhone" value="{{$client[0]->clientPhone}}" placeholder="04124231242" disabled>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label for="clientEmail">{{__('email')}}</label>
                <input type="email" class="form-control" id="clientEmail" name="clientEmail" value="{{$client[0]->clientEmail}}" placeholder="Correo" disabled>
              </div>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-danger  button-prevent-multiple-submits">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
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
