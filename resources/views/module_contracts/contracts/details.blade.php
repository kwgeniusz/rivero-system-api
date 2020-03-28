@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-default col-xs-10 col-lg-7">
    <div class="panel-heading"> <h3><b>{{__('contract_details')}}</b></h3></div>
    <div class="panel-body">

      <form class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-5 control-label">CONTROL NUMBER</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->contractNumber }}</p>
          </div>
        </div>
      <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('country')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->country->countryName }}</p>
          </div>
        </div>
     </div>

       <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('office')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->office->officeName }}</p>
          </div>
        </div>
       </div>

        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('date_of_contract')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->contractDate }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">CLIENTE ID</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->client->clientCode }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('client')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->client->clientName }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('address')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->siteAddress }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">DESCRIPCION DE PROYECTO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->projectDescription->projectDescriptionName }}</p>
          </div>
        </div>
         <div class="form-group">
          <label class="col-sm-5 control-label">USO DE PROYECTO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->projectUse->projectUseName }}</p>
          </div>
        </div>
        <!-- <div class="form-group">
          <label class="col-sm-5 control-label">N° {{__('registration')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->registryNumber }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('start_date')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->startDate }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('scheduled_finish_date')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->scheduledFinishDate }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('finish_date')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->actualFinishDate }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('delivery_date')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->deliveryDate }}</p>
          </div>
        </div> -->
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('initial_comment')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->initialComment }}</p>
          </div>
        </div>
        <!-- <div class="form-group">
          <label class="col-sm-5 control-label">{{__('intermediate_comment')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->intermediateComment }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('final_comment')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->finalComment }}</p>
          </div>
        </div> -->

   <!--     <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('contract_cost')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ number_format( $contract[0]->contractCost, 2, ',', '.') }}</p>
          </div>
        </div>
      </div> -->
      <div class="col-xs-6">
        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('currency')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $contract[0]->currency->currencyName }}</p>
          </div>
        </div>
      </div>
            <div class="text-center">

              <a href="{{route('contracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
            </div>
          </form>


    </div>

  </div>

@endsection
