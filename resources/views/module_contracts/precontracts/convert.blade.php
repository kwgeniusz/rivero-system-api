@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-lg-8 col-lg-offset-2">
<div class="panel panel-warning">
    <div class="panel-heading text-center"> <h3><b>¿Esta Seguro de Convertir este Precontrato a Contrato?</b></h3></div>
    <div class="panel-body">

      <form class="form-horizontal form-prevent-multiple-submits" action="{{Route('precontracts.convertAdd',['id' => $proposal[0]->proposalId])}}" method="POST">
        {{csrf_field()}}
        <div class="form-group">
          <label class="col-lg-5 control-label">PRECONTRACTO ID</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{ $precontract->preId }}</p>
          </div>
        </div>
           
      <div class="col-xs-6">
        <div class="form-group">
          <label class="col-lg-5 control-label">{{__('country')}}</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{ $precontract->country->countryName }}</p>
          </div>
        </div>
     </div>

       <div class="col-xs-6">
        <div class="form-group">
          <label class="col-lg-5 control-label">COMPAÑIA</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{ $precontract->company->companyName }}</p>
          </div>
        </div>
       </div>
      <div class="form-group">
          <label class="col-lg-5 control-label">FECHA</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{ $precontract->precontractDate }}</p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-5 control-label">{{__('client')}}</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{ $precontract->client->clientName }}</p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-5 control-label">TIPO DE CONTRATO</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{ $precontract->contractType }}</p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-lg-5 control-label">{{__('address')}}</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{ $precontract->siteAddress }}</p>
          </div>
        </div>
{{--           <div class="form-group">
          <label class="col-lg-5 control-label">DESCRIPCION DE PROYECTO</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{ $precontract->projectDescription->projectDescriptionName }}</p>
          </div>
        </div> --}}
       <div class="form-group">
          <label class="col-lg-5 control-label">INTERNATIONAL BUILDING CODE (IBM)</label>
          <div class="col-lg-7">
            <p class="form-control-static">
            @if($precontract->buildingCodeId)    
              {{ $precontract->buildingCode->buildingCodeName }}
            @endif
            </p>
          </div>
      </div> 
       <div class="form-group">
          <label class="col-lg-5 control-label">GRUPO</label>
          <div class="col-lg-7">
            <p class="form-control-static">
            @if($precontract->groupId)    
              {{ $precontract->buildingCodeGroup->groupName }}
            @endif  
            </p>
          </div>
      </div> 
         <div class="form-group">
          <label class="col-lg-5 control-label">USO DEL PROYECTO</label>
          <div class="col-lg-7">
            <p class="form-control-static">
            @if($precontract->projectUseId)                  
            {{ $precontract->projectUse->projectUseName }}
            @endif
          </p>
          </div>
        </div>
         <div class="form-group">
          <label class="col-lg-5 control-label">TIPO DE CONSTRUCCIÓN</label>
          <div class="col-lg-7">
            <p class="form-control-static">
            @if($precontract->constructionType)    
              {{ $precontract->constructionType }}
            @endif  
            </p>
          </div>
        </div> 
           <div class="form-group">
          <label class="col-lg-5 control-label">{{__('initial_comment')}}</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{ $precontract->comment }}</p>
          </div>
        </div>
{{--        <div class="col-xs-6">
        <div class="form-group">
          <label class="col-lg-5 control-label">{{__('contract_cost')}}</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{  number_format( $precontract->precontractCost, 2, ',', '.')}}</p>
          </div>
        </div>
      </div> --}}
      <div class="col-xs-12">
        <div class="form-group">
          <label class="col-lg-5 control-label">{{__('currency')}}</label>
          <div class="col-lg-7">
            <p class="form-control-static">{{ $precontract->currency->currencyName }}</p>
          </div>
        </div>
      </div>




            <div class="text-center">
              <button type="submit" class="btn btn-success  button-prevent-multiple-submits">
                <span class="fa fa-sync" aria-hidden="true"></span>  Convertir
              </button>
                 <a href="{{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
       </a>
              {{-- <a href="{{url("/proposals?id=$precontract->precontractId")}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a> --}}
            </div>
            </div>
          </form>


    </div>

  </div>

@endsection
