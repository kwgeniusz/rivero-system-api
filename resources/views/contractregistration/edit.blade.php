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
    <div class="panel-heading"> <h3><b>{{__('edit_contract')}}</b></h3></div>
    <div class="panel-body">

  <form class="form" action="{{Route('contracts.update',['id' => $contract[0]->contractId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}

        <div class="form-group col-xs-7">
           <label for="contractNumber">N° {{__('contract')}} </label>
           <input disabled type="text" class="form-control" id="contractNumber" name="contractNumber" value="{{ $contract[0]->contractNumber }}" placeholder="JDR-000000-18">
         </div>


         <select-country-office-edit country="{{$contract[0]->countryId}}" office="{{$contract[0]->officeId}}"></select-country-office-edit>

                <div class="form-group col-xs-5">
                  <label for="contractDate">{{__('date_of_contract')}}</label>
                  <input class="form-control flatpickr"  id="contractDate" name="contractDate" value="{{ $contract[0]->contractDate }}">
                </div>


           <div class="row"></div>
           <search-client url='E' c-id="{{$contract[0]->clientId}}" c-name="{{$contract[0]->client->clientName}}"></search-client>

              <div class="form-group col-xs-11">
                <label for="siteAddress">{{__('address')}}</label>
                <input type="text"  class="form-control" id="siteAddress" name="siteAddress" value="{{ $contract[0]->siteAddress }}">
              </div>


          <div class="form-group col-xs-7">
            <label for="projectTypeId">DESCRIPCION DE PROYECTO</label>
            <select class="form-control" name="projectTypeId" id="projectTypeId">
                @foreach($projects as $project)
                   @if ($project->projectTypeId == $contract[0]->projectTypeId)
              <option value="{{$project->projectTypeId}}"selected> {{$project->projectTypeName}} </option>
                  @else
               <option value="{{$project->projectTypeId}}"> {{$project->projectTypeName}} </option>
               @endif
                @endforeach
            </select>
          </div>

         <div class="form-group col-xs-7">
            <label for="serviceTypeId">TIPO DE PROYECTO</label>
            <select class="form-control" name="serviceTypeId" id="serviceTypeId">
              @foreach($services as $service)
                   @if ($service->serviceTypeId == $contract[0]->serviceTypeId)
              <option value="{{$service->serviceTypeId}}"selected> {{$service->serviceTypeName}} </option>
                  @else
               <option value="{{$service->serviceTypeId}}"> {{$service->serviceTypeName}} </option>
                  @endif
                @endforeach
            </select>
          </div>

           <div class="row"></div>
              <div class="form-group col-xs-6 ">
                <label for="registryNumber">N° {{__('registration')}}</label>
                <input type="text" class="form-control" id="registryNumber" name="registryNumber" value="{{ $contract[0]->registryNumber }}">
              </div>

          <div class="row"></div>
              <div class="form-group col-xs-5">
                <label for="startDate">{{__('start_date')}}</label>
                <input class="form-control flatpickr" id="startDate" name="startDate" value="{{ $contract[0]->startDate }}">
              </div>

          <div class="row"></div>
              <div class="form-group">
                <label class="col-xs-8" for="scheduledFinishDate">{{__('scheduled_finish_date')}}</label>
                 <div class="col-xs-5">
                  <input class="form-control flatpickr" id="scheduledFinishDate" name="scheduledFinishDate" value="{{ $contract[0]->scheduledFinishDate }}">
                </div>
              </div>

          <div class="row"></div>
              <div class="form-group col-xs-5">
                <label for="actualFinishDate">{{__('finish_date')}}</label>
                <input class="form-control flatpickr" id="actualFinishDate" name="actualFinishDate" value="{{ $contract[0]->actualFinishDate}}">


                <label for="deliveryDate">{{__('delivery_date')}}</label>
                <input class="form-control flatpickr" id="deliveryDate" name="deliveryDate" value="{{ $contract[0]->deliveryDate}}">
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
              <select class="form-control" name="currencyName" id="currencyName">
                   @if($contract[0]->currencyName == "USD")
                    <option value="USD" selected> USD </option>
                    <option value="BS" > BS </option>
                    @else
                    <option value="USD"> USD </option>
                    <option value="BS" selected> BS </option>
                    @endif
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

   </form>


    </div>

  </div>


@endsection
