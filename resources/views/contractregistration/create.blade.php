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
 <div class="panel panel-success col-xs-10 col-lg-7">
   @if($contractType == 'P')
    <div class="panel-heading"> <h3><b>Nuevo Proyecto</b><h3></div>
   @elseif($contractType == 'S')
    <div class="panel-heading"> <h3><b>Nuevo Servicio</b></h3></div>
    @endif
    <div class="panel-body">

      <form class="form" action="{{Route('contracts.store')}}" method="POST">
        {{csrf_field()}}

        <select-country-office></select-country-office>

            <input type="hidden" name="contractType" value="{{ $contractType }}">

             <div class="row"></div>
                <div class="form-group col-xs-5">
                  <label for="contractDate">{{__('date_of_contract')}}</label>
                  <input class="form-control flatpickr" id="contractDate" name="contractDate" value="{{ old('contractDate') }}">
                </div>

<!--
         <div class="row"></div>
          <div class="form-group col-xs-7">
            <label for="clientId">{{__('client')}}</label>
            <select class="form-control" name="clientId" id="clientId">
                @foreach($clients as $client)
                      <option value="{{$client->clientId}}" > {{$client->clientName}} </option>
                @endforeach
            </select>
          </div>
-->

           <div class="row"></div>
           <search-client></search-client>


          <div class="form-group col-xs-7">
            <label for="projectTypeId">DESCRIPCION DE PROYECTO</label>
            <select class="form-control" name="projectTypeId" id="projectTypeId">
                @foreach($projects as $project)
                      <option value="{{$project->projectTypeId}}" > {{$project->projectTypeName}} </option>
                @endforeach
            </select>
          </div>

             <div class="form-group col-xs-7">
            <label for="serviceTypeId">TIPO DE PROYECTO</label>
            <select class="form-control" name="serviceTypeId" id="serviceTypeId">
                @foreach($services as $service)
                      <option value="{{$service->serviceTypeId}}" > {{$service->serviceTypeName}} </option>
                @endforeach
            </select>
          </div>



           <div class="row"></div>
              <div class="form-group col-xs-6 ">
                <label for="registryNumber">N° {{__('registration')}}</label>
                <input type="text" class="form-control" id="registryNumber" name="registryNumber" value="{{ old('registryNumber') }}">
              </div>


        <div class="row"></div>
              <div class="form-group col-xs-5">
                <label for="startDate">{{__('start_date')}}</label>
                <input class="form-control flatpickr" id="startDate" name="startDate" value="{{ old('startDate') }}">
              </div>

        <div class="row"></div>
              <div class="form-group">
                <label class="col-xs-8" for="scheduledFinishDate">{{__('scheduled_finish_date')}}</label>
                <div class="col-xs-5">
                <input class="form-control flatpickr" id="scheduledFinishDate" name="scheduledFinishDate" value="{{ old('scheduledFinishDate') }}">
                </div>
              </div>

        <div class="row"></div>
              <div class="form-group col-xs-5">
                <label for="actualFinishDate">{{__('finish_date')}}</label>
                <input class="form-control flatpickr" id="actualFinishDate" name="actualFinishDate" value="{{ old('actualFinishDate') }}">
              </div>

         <div class="row"></div>
             <div class="form-group col-xs-5">
                <label for="deliveryDate">{{__('delivery_date')}}</label>
                <input class="form-control flatpickr" id="deliveryDate" name="deliveryDate" value="{{ old('deliveryDate') }}">
            </div>


          <div class="col-xs-12">
             <div class="form-group">
                <label for="initialComment">{{__('initial_comment')}}</label>
                <textarea class="form-control" id="initialComment" name="initialComment" value="{{ old('initialComment') }}" rows="3"></textarea>
              </div>
              </div>


            <div class="col-xs-6">
               <div class="form-group">
              <label for="currencyName">{{__('currency')}}</label>
              <select class="form-control" name="currencyName" id="currencyName" value="{{ old('currencyName') }}">
                    <option value="USD" > USD </option>
                    <option value="BS" > BS </option>
              </select>
              </div>
            </div>


            <div class="col-xs-12 text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('submit')}}
              </button>
              <a href="{{route('contracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>

          </form>


    </div>

  </div>

@endsection
