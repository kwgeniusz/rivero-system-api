@extends('layouts.master')

@section('content')
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
        </div>
      </div>
<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-success col-xs-7">
   @if($contractType == 'P')
    <div class="panel-heading"> <h3>Nuevo Proyecto</h3></div>
   @elseif($contractType == 'S')
    <div class="panel-heading"> <h3>Nuevo Servicio</h3></div>
    @endif
    <div class="panel-body">

      <form class="form" action="{{Route('contracts.store')}}" method="POST">
        {{csrf_field()}}

        <select-country-office></select-country-office>

            <div class="col-xs-12">

            <input type="hidden" name="contractType" value="{{ $contractType }}">


                <div class="form-group">
                  <label for="contractDate">{{__('date_of_contract')}}</label>
                  <input type="date" class="form-control" id="contractDate" name="contractDate" value="{{ old('contractDate') }}">
                </div>

          <div class="form-group">
            <label for="clientId">{{__('client')}}</label>
            <select class="form-control" name="clientId" id="clientId">
                @foreach($clients as $client)
                      <option value="{{$client->clientId}}" > {{$client->clientName}} </option>
                @endforeach
            </select>
          </div>
              <div class="form-group">
                <label for="siteAddress">{{__('address')}}</label>
                <input type="text" class="form-control" id="siteAddress" name="siteAddress" value="{{ old('siteAddress') }}">
              </div>

              <div class="form-group">
                <label for="contractDescription">{{__('description')}}</label>
                <input type="text" class="form-control" id="contractDescription" name="contractDescription" value="{{ old('contractDescription') }}">
              </div>

              <div class="form-group">
                <label for="registryNumber">N° {{__('registration')}}</label>
                <input type="number" class="form-control" id="registryNumber" name="registryNumber" value="{{ old('registryNumber') }}">
              </div>

            <div class="col-xs-12">
              <div class="form-group">
                <label for="startDate">{{__('start_date')}}</label>
                <input type="date" class="form-control" id="startDate" name="startDate" value="{{ old('startDate') }}">
              </div>
              <div class="form-group">
                <label for="scheduledFinishDate">{{__('scheduled_finish_date')}}</label>
                <input type="date" class="form-control" id="scheduledFinishDate" name="scheduledFinishDate" value="{{ old('scheduledFinishDate') }}">
              </div>
              <div class="form-group">
                <label for="actualFinishDate">{{__('finish_date')}}</label>
                <input type="date" class="form-control" id="actualFinishDate" name="actualFinishDate" value="{{ old('actualFinishDate') }}">
              </div>

            <div class="form-group">
                <label for="deliveryDate">{{__('delivery_date')}}</label>
                <input type="date" class="form-control" id="deliveryDate" name="deliveryDate" value="{{ old('deliveryDate') }}">
              </div>
           </div>
          </div>
          <div class="col-xs-12">
             <div class="form-group">
                <label for="initialComment">{{__('initial_comment')}}</label>
                <textarea class="form-control" id="initialComment" name="initialComment" value="{{ old('initialComment') }}" rows="3"></textarea>
              </div>
              </div>

         <div class="col-xs-6">
              <div class="form-group">
                <label for="contractCost">{{__('contract_cost')}}</label>
                <input type="number" class="form-control" step="0.01" id="contractCost" name="contractCost" value="{{ old('contractCost') }}">
              </div>
        </div>

            <div class="col-xs-6">
               <div class="form-group">
              <label for="currencyName">{{__('currency')}}</label>
              <select class="form-control" name="currencyName" id="currencyName" value="{{ old('currencyName') }}">
                    <option value="BS" > BS </option>
                    <option value="USD" > USD </option>
              </select>
              </div>
            </div>


            <div class="col-xs-12 text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('submit')}}
              </button>
              <a href="{{route('contracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
            </div>
          </form>


    </div>

  </div>

@endsection
