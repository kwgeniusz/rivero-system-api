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
    <div class="panel-heading"> <h3>{{__('edit_contract')}}</h3></div>
    <div class="panel-body">

      <form class="form" action="{{Route('contracts.update',['id' => $contract[0]->contractId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}

        <div class="form-group">
           <label for="contractNumber">N° {{__('contract')}} </label>
           <input disabled type="text" class="form-control" id="contractNumber" name="contractNumber" value="{{ $contract[0]->contractNumber }}" placeholder="JDR-000000-18">
         </div>


         <select-country-office-edit></select-country-office-edit>
            
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="contractDate">{{__('date_of_contract')}}</label>
                  <input type="date" class="form-control" id="contractDate" name="contractDate" value="{{ $contract[0]->contractDate }}">
                </div>

            <div class="form-group">
                      <label for="clientId">{{__('client')}}</label>
                      <select class="form-control" name="clientId" id="clientId">
                    @foreach($clients as $client) 
                        @if ($client->clientId == $contract[0]->clientId)
                           <option value="{{$client->clientId}}" selected> {{$client->clientName}} </option>
                        @else
                           <option value="{{$client->clientId}}" > {{$client->clientName}} </option>
                        @endif
                    @endforeach   
                    </select>
            </div>  

              <div class="form-group">
                <label for="siteAddress">{{__('address')}}</label>
                <input type="text"  class="form-control" id="siteAddress" name="siteAddress" value="{{ $contract[0]->siteAddress }}">
              </div>
             
              <div class="form-group">
                <label for="contractDescription">{{__('description')}}</label>
                <input type="text" class="form-control" id="contractDescription" name="contractDescription" value="{{ $contract[0]->contractDescription }}">
              </div>

              <div class="form-group">
                <label for="registryNumber">N° {{__('registration')}}</label>
                <input type="number" class="form-control" id="registryNumber" name="registryNumber" value="{{ $contract[0]->registryNumber }}">
              </div>

            <div class="col-xs-12">
              <div class="form-group">
                <label for="startDate">{{__('start_date')}}</label>
                <input type="date" class="form-control" id="startDate" name="startDate" value="{{ $contract[0]->startDate }}">
              </div>
              <div class="form-group">
                <label for="scheduledFinishDate">{{__('scheduled_finish_date')}}</label>
                <input type="date" class="form-control" id="scheduledFinishDate" name="scheduledFinishDate" value="{{ $contract[0]->scheduledFinishDate }}">
              </div>
              <div class="form-group">
                <label for="actualFinishDate">{{__('finish_date')}}</label>
                <input type="date" class="form-control" id="actualFinishDate" name="actualFinishDate" value="{{ $contract[0]->actualFinishDate}}">
              </div>
              <div class="form-group">
                <label for="deliveryDate">{{__('delivery_date')}}</label>
                <input type="date" class="form-control" id="deliveryDate" name="deliveryDate" value="{{  $contract[0]->deliveryDate }}">
              </div>
           </div>
           </div>
        <div class="col-xs-12">
             <div class="form-group">
                <label for="initialComment">{{__('initial_comment')}}</label>
                <textarea class="form-control" id="initialComment" name="initialComment" rows="3">{{ $contract[0]->initialComment }}</textarea>
              </div>
             <div class="form-group">
                <label for="intermediateComment">{{__('intermediate_comment')}}</label>
                <textarea class="form-control" id="intermediateComment" name="intermediateComment" rows="3">{{ $contract[0]->intermediateComment }}</textarea>
              </div>
             <div class="form-group">
                <label for="finalComment">{{__('final_comment')}}</label>
                <textarea class="form-control" id="finalComment" name="finalComment" rows="3">{{ $contract[0]->finalComment }}</textarea>
              </div>
              </div>

         <div class="col-xs-6">
              <div class="form-group">
                <label for="contractCost">{{__('contract_cost')}}</label>
                <input type="number" class="form-control" step="0.01" id="contractCost" name="contractCost" value="{{ $contract[0]->contractCost }}">
              </div>
        </div>

            <div class="col-xs-6">
               <div class="form-group">
              <label for="currencyName">{{__('currency')}}</label>
              <select class="form-control" name="currencyName" id="currencyName" value="{{ $contract[0]->currencyName }}">
                    <option value="BS" > BS </option>  
                    <option value="USD" > USD </option>  
              </select>
              </div>  
            </div>
            
          <div class="col-xs-12">
            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('submit')}}
              </button>
              <a href="{{route('contracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
          </div>

        </div>
   </form>


    </div>

  </div>

@endsection
