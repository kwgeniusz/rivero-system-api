@extends('layouts.master')

@section('content')
<div class="row col-xs-12">
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

<div class="col-xs-12 col-lg-10 col-lg-offset-1">
<div class="panel panel-success ">
    <div class="panel-heading text-center"> <h3><b>{{__('edit_contract')}}</b></h3></div>
    <div class="panel-body">

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  @can('BDC') 
    <li role="presentation" class="active"><a href="#basicInformation" aria-controls="basicInformation" role="tab" data-toggle="tab">Informacion Basica</a></li>
  @endcan
  @can('BDCA') 
    <li role="presentation"><a href="#IBC" aria-controls="IBC" role="tab" data-toggle="tab">International Building Code</a></li>
  @endcan
</ul>

  <br>

<!-- Tab panes -->
<div class="tab-content">
@can('BDC') 

  <div role="tabpanel" class="tab-pane active" id="basicInformation">
  <form class="form" action="{{Route('contracts.update',['id' => $contract[0]->contractId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}

        <div class="form-group col-lg-7">
           <label for="contractNumber">CONTROL NUMBER </label>
           <input disabled type="text" class="form-control" id="contractNumber" name="contractNumber" value="{{ $contract[0]->contractNumber }}" placeholder="JDR-000000-18">
         </div>

    <div class="row"></div>
     <div class="form-group col-lg-7">
                 <label for="projectName">NOMBRE DEL PROYECTO</label>
                <input type="text" value="{{ $contract[0]->projectName }}" class="form-control" id="projectName" name="projectName">
    </div>

   <div class="col-lg-6">
         <div class="form-group">
            <label for="countryId">Pais</label>
             <input disabled type="text" class="form-control" id="countryId" name="countryId" value="{{ $contract[0]->country->countryName }}">
          </div>  
        </div>  
 
      <div class="col-lg-6">
         <div class="form-group">
            <label for="companyId">Oficina</label>
             <input disabled type="text" class="form-control" id="companyId" name="companyId" value="{{ $contract[0]->company->companyName }}">
          </div> 
    </div>

                <div class="form-group col-lg-5">
                  <label for="contractDate">{{__('date_of_contract')}}</label>
                  <input class="form-control flatpickr"  id="contractDate" name="contractDate" value="{{ $contract[0]->contractDate }}">
                </div>
        
@if($blockEdit == false)
           <div class="row"></div>
           <search-client pref-url='../../' c-id="{{$contract[0]->clientId}}" c-name="{{$contract[0]->client->clientName}}" c-address="{{$contract[0]->siteAddress}}"></search-client>

          <div class="form-group col-lg-6">
            <label for="contractType">TIPO DE CONTRATO</label>
            <select class="form-control" name="contractType" id="contractType">
                 @foreach($currencies as $currency)
                   @if ('P' == $contract[0]->contractType)
                     <option value="P" selected>P</option>
                     <option value="S" >S</option>
                  @else
                     <option value="P">P</option>
                     <option value="S" selected>S</option>
                  @endif
                @endforeach
            </select>
          </div>
       <!--input Address-->      
        <div class="form-group col-lg-7">
                <label for="propertyNumber">NUMERO DE LA PROPIEDAD</label>
                <input type="number" value="{{$contract[0]->propertyNumber }}" class="form-control" id="propertyNumber" name="propertyNumber" placeholder="5924">
           </div>
           <div class="form-group col-lg-7">
                <label for="streetName">CALLE</label>
                <input type="text" maxlength="20" value="{{$contract[0]->streetName }}" class="form-control" id="streetName" name="streetName" placeholder="AZALEA">
           </div>
            <div class="form-group col-lg-3">
                <label for="streetType">TIPO DE CALLE</label>
                <input type="text" maxlength="10" value="{{$contract[0]->streetType }}" class="form-control" id="streetType" name="streetType" placeholder="LN">
           </div>
           <div class="form-group col-lg-6">
                <label for="suiteNumber">SUITE NUMBER</label>
                <input type="text" maxlength="20" value="{{$contract[0]->suiteNumber }}" class="form-control" id="suiteNumber" name="suiteNumber" placeholder="SUITE 114 (Opcional)">
           </div>
            <div class="form-group col-lg-8">
                <label for="city">CIUDAD</label>
                <input type="text" maxlength="20" value="{{$contract[0]->city }}" class="form-control" id="city" name="city" placeholder="DALLAS">
           </div>
           <div class="form-group col-lg-8">
                <label for="state">ESTADO</label>
                <input type="text" maxlength="20" value="{{$contract[0]->state }}" class="form-control" id="state" name="state" placeholder="TX">
           </div>
                   <div class="row"></div>
            <div class="form-group col-lg-4">
                <label for="zipCode">CODIGO POSTAL</label>
                <input type="number" value="{{$contract[0]->zipCode }}" class="form-control" id="zipCode" name="zipCode" placeholder="75230">
           </div>

      <div class="row"></div>
       <div class="form-group col-lg-8">
       <label for="projectUseId">USO DEL PROYECTO</label>: 
       <input class="form-check-input" type="radio" name="projectUseId" id="inlineRadio1" value="1" {{ ($contract[0]->projectUseId == '1')? "checked" : "" }}>
       <label class="form-check-label" for="inlineRadio1">COM</label>
        <input class="form-check-input" type="radio" name="projectUseId" id="inlineRadio2" value="2" {{ ($contract[0]->projectUseId == '2')? "checked" : "" }}>
        <label class="form-check-label" for="inlineRadio2">RES</label>
      </div>
  @else
         <div class="row"></div>
              <div class="form-group col-lg-6 ">
                <label for="clientId">{{__('client')}}</label>
                <input disabled type="text" class="form-control" id="clientId" value="{{ $contract[0]->client->clientName }}">
              </div>
           <input type="hidden" name="clientId" value="{{ $contract[0]->clientId }}">

       <!--input Address-->      
          <div class="form-group col-lg-11">
                <label for="siteAddress">DIRECCIÓN</label>
                <input disabled type="text" class="form-control" id="siteAddress" name="siteAddress" value="{{ $contract[0]->siteAddress }}">
           </div>  
           <input type="hidden" name="siteAddress"  value="{{ $contract[0]->siteAddress }}">

          <div class="form-group col-lg-7">
            <label for="projectDescriptionId">DESCRIPCION DE PROYECTO</label>
             <input disabled type="text" class="form-control" id="projectDescriptionId" name="projectDescriptionId" value="{{ $contract[0]->projectDescription->projectDescriptionName }}">
          </div>
           <input type="hidden" name="projectDescriptionId"  value="{{ $contract[0]->projectDescriptionId  }}">

         <div class="form-group col-lg-7">
            <label for="projectUseId">USO DE PROYECTO</label>
              <input disabled type="text" class="form-control" id="projectUseId" value="{{ $contract[0]->projectUse->projectUseName }}">
          </div>
          <input type="hidden" name="projectUseId" value="{{ $contract[0]->projectUseId }}">
@endif

             <div class="form-group col-lg-12">
                <label for="initialComment">{{__('initial_comment')}}</label>
                <textarea class="form-control" id="initialComment" name="initialComment" rows="3">{{ $contract[0]->initialComment }}</textarea>
              </div>
  
@if($blockEdit == false)
    <div class="form-group col-lg-6">
            <label for="currencyId">{{__('currency')}}</label>
            <select class="form-control" name="currencyId" id="currencyId">
              @foreach($currencies as $currency)
                   @if ($currency->currencyId == $contract[0]->currencyId)
              <option value="{{$currency->currencyId}}"selected> {{$currency->currencyName}} </option>
                  @else
               <option value="{{$currency->currencyId}}"> {{$currency->currencyName}} </option>
                  @endif
                @endforeach
            </select>
    </div>
@else

            <div class="form-group col-lg-6">
              <label for="currencyId">{{__('currency')}}</label>
              <input disabled type="text" class="form-control" id="currencyId"  value="{{ $contract[0]->currency->currencyName }}">
            </div>
          <input type="hidden" name="currencyId" value="{{ $contract[0]->currencyId }}">     
@endif
          <div class="col-lg-12 text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('update')}}
              </button>
              <a href="{{route('contracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>

   </form>
  </div>
@endcan

@can('BDCA') 
  <div role="tabpanel" class="tab-pane" id="IBC">
  <form class="form" action="{{Route('contracts.updateIbc',['id' => $contract[0]->contractId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}

           <select-building-code 
             pref-Url='../../' 
             prop-building-code='{{$contract[0]->buildingCodeId}}' 
             prop-building-code-group='{{$contract[0]->groupId}}' 
             prop-project-use='{{$contract[0]->projectUseId}}'
             prop-construction-type='{{$contract[0]->constructionType}}'></select-building-code> 

          <div class="col-lg-12">
            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('update')}}
              </button>
              <a href="{{route('contracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
          </div>
  </form>
  </div>
@endcan
    </div>

  </div>
  </div>
  </div>


@endsection
