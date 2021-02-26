@extends('layouts.master')
  @section('content')
    <div class="create">
      <div class="formulario">

        <h3><i class="fas fa-file-signature"></i> {{__('edit_contract')}}</h3>
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
          <div class="panel-body" style="width: 100%">
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
              <div role="tabpanel" class="tab-pane active"  style="width: 100%;" id="basicInformation">
                <form style="width: 100%; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;" action="{{Route('contracts.update',['id' => $contract[0]->contractId])}}" method="POST">
                  {{csrf_field()}}
                  {{method_field('PUT')}}
                  <div class="inputother boxes2">
                    <label for="contractNumber"><i class="fas fa-book"></i> CONTROL NUMBER</label>
                    <input disabled type="text" style="cursor: no-drop" class="input-label" id="contractNumber" name="contractNumber" value="{{ $contract[0]->contractNumber }}" placeholder="JDR-000000-18">
                  </div>
                  <div class="inputother boxes2">
                    <label for="projectName"><i class="fas fa-file-signature"></i> NOMBRE DEL PROYECTO</label>
                    <input type="text" value="{{ $contract[0]->projectName }}" class="input-label" id="projectName" name="projectName">
                  </div>
                  <div class="inputother boxes2">
                    <label for="countryId"><i class="fas fa-globe-americas"></i> Pais</label>
                    <input disabled type="text" style="cursor: no-drop" class="input-label" id="countryId" name="countryId" value="{{ $contract[0]->country->countryName }}">
                  </div> 
                  <div class="inputother boxes2">
                    <label for="companyId"><i class="fas fa-globe"></i> Oficina</label>
                    <input disabled type="text" style="cursor: no-drop" class="input-label" id="companyId" name="companyId" value="{{ $contract[0]->company->companyName }}">
                  </div> 
                  <div class="inputother boxes2">
                    <label for="contractDate"><i class="fas fa-calendar-alt"></i> {{__('date_of_contract')}}</label>
                    <input class="input-label flatpickr"  id="contractDate" name="contractDate" value="{{ $contract[0]->contractDate }}">
                  </div>
                  @if($blockEdit == false)
                    <search-client pref-url='../../' c-id="{{$contract[0]->clientId}}" c-name="{{$contract[0]->client->clientName}}" c-address="{{$contract[0]->siteAddress}}"></search-client>
                    <div class="inputother boxes2">
                      <label for="contractType"><i class="fas fa-file-contract"></i> TIPO DE CONTRATO</label>
                      <select name="contractType" id="contractType">
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
                    <div class="inputother boxes2">
                      <label for="propertyNumber"><i class="fas fa-home"></i> NUMERO DE LA PROPIEDAD</label>
                      <input type="number" value="{{$contract[0]->propertyNumber }}" class="input-label" id="propertyNumber" name="propertyNumber" placeholder="5924">
                    </div>
                    <div class="inputother boxes2">
                      <label for="streetName"><i class="fas fa-road"></i> CALLE</label>
                      <input type="text" maxlength="20" value="{{$contract[0]->streetName }}" class="input-label" id="streetName" name="streetName" placeholder="AZALEA">
                    </div>
                    <div class="inputother boxes2">
                      <label for="streetType"><i class="fas fa-street-view"></i> TIPO DE CALLE</label>
                      <input type="text" maxlength="10" value="{{$contract[0]->streetType }}" class="input-label" id="streetType" name="streetType" placeholder="LN">
                    </div>
                    <div class="inputother boxes2">
                      <label for="suiteNumber"><i class="fas fa-building"></i> SUITE NUMBER</label>
                      <input type="text" maxlength="20" value="{{$contract[0]->suiteNumber }}" class="input-label" id="suiteNumber" name="suiteNumber" placeholder="SUITE 114 (Opcional)">
                    </div>
                    <div class="inputother boxes2">
                      <label for="city"><i class="fas fa-map"></i> CIUDAD</label>
                      <input type="text" maxlength="20" value="{{$contract[0]->city }}" class="input-label" id="city" name="city" placeholder="DALLAS">
                    </div>
                    <div class="inputother boxes2">
                      <label for="state"><i class="fas fa-compass"></i> ESTADO</label>
                      <input type="text" maxlength="20" value="{{$contract[0]->state }}" class="input-label" id="state" name="state" placeholder="TX">
                    </div>
                    <div class="inputother boxes2">
                      <label for="zipCode"><i class="fas fa-envelope"></i> CODIGO POSTAL</label>
                      <input type="number" value="{{$contract[0]->zipCode }}" class="input-label" id="zipCode" name="zipCode" placeholder="75230">
                    </div>
                    <div class="inputother boxes2">
                      <label for="projectUseId">USO DEL PROYECTO</label>: 
                      <div class="input-label">
                        <input class="input" type="radio" name="projectUseId" id="inlineRadio1" value="1" {{ ($contract[0]->projectUseId == '1')? "checked" : "" }}>
                        <label style="width: 48%; margin-bottom: 0px;" for="inlineRadio1">COM</label>
                      </div>
                      <div class="input-label">
                        <input class="input" type="radio" name="projectUseId" id="inlineRadio2" value="2" {{ ($contract[0]->projectUseId == '2')? "checked" : "" }}>
                        <label style="width: 48%; margin-bottom: 0px;" for="inlineRadio2">RES</label>
                      </div>
                    </div>
                  @else
                    <div class="inputother boxes2">
                      <label for="clientId">{{__('client')}}</label>
                      <input disabled type="text" style="cursor: no-drop" class="input-label" id="clientId" value="{{ $contract[0]->client->clientName }}">
                    </div>
                    <input type="hidden" name="clientId" value="{{ $contract[0]->clientId }}">
                    <!--input Address-->      
                    <div class="inputother boxes2">
                      <label for="siteAddress">DIRECCIÓN</label>
                      <input disabled type="text" style="cursor: no-drop" class="input-label" id="siteAddress" name="siteAddress" value="{{ $contract[0]->siteAddress }}">
                    </div>  
                    <input type="hidden" name="siteAddress"  value="{{ $contract[0]->siteAddress }}">
                    <div class="inputother boxes2">
                      <label for="projectDescriptionId">DESCRIPCION DE PROYECTO</label>
                      <input disabled type="text" style="cursor: no-drop" class="input-label" id="projectDescriptionId" name="projectDescriptionId" value="{{ $contract[0]->projectDescription->projectDescriptionName }}">
                    </div>
                    <input type="hidden" name="projectDescriptionId"  value="{{ $contract[0]->projectDescriptionId  }}">
                    <div class="inputother boxes2">
                      <label for="projectUseId">USO DE PROYECTO</label>
                      <input disabled type="text" style="cursor: no-drop" class="input-label" id="projectUseId" value="{{ $contract[0]->projectUse->projectUseName }}">
                    </div>
                    <input type="hidden" name="projectUseId" value="{{ $contract[0]->projectUseId }}">
                  @endif
                  @if($blockEdit == false)
                    <div class="inputother boxes2">
                      <label for="currencyId"><i class="fas fa-donate"></i> {{__('currency')}}</label>
                      <select name="currencyId" id="currencyId">
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
                    <div class="inputother boxes2">
                      <label for="currencyId"><i class="fas fa-donate"></i> {{__('currency')}}</label>
                      <input disabled type="text" style="cursor: no-drop" class="input-label" id="currencyId"  value="{{ $contract[0]->currency->currencyName }}">
                    </div>
                    <input type="hidden" name="currencyId" value="{{ $contract[0]->currencyId }}">     
                  @endif
                  <div class="input-label">
                    <label for="initialComment"><i class="fas fa-comment-alt"></i> {{__('initial_comment')}}</label>
                    <textarea id="initialComment" name="initialComment" rows="3">{{ $contract[0]->initialComment }}</textarea>
                  </div>
                  <div style="width: 100%; text-align: center;">
                    <button type="submit" class="submit">
                      <span class="fa fa-check" aria-hidden="true"></span>  {{__('update')}}
                    </button>
                    <a href="{{route('contracts.index')}}" class="return">
                        <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                    </a>
                  </div>
                </form>
              </div>
            @endcan
            @can('BDCA') 
            
              <div role="tabpanel"  class="tab-pane"  id="IBC">
                <form  action="{{Route('contracts.updateIbc',['id' => $contract[0]->contractId])}}" method="POST">

                  {{csrf_field()}}
                  {{method_field('PUT')}}
                  <select-building-code 
                    pref-Url='../../' 
                    prop-building-code='{{$contract[0]->buildingCodeId}}' 
                    prop-building-code-group='{{$contract[0]->groupId}}' 
                    prop-project-use='{{$contract[0]->projectUseId}}'
                    prop-construction-type='{{$contract[0]->constructionType}}'>
                  </select-building-code> 

                  <div class="col-lg-12 text-center">
                    <button type="submit" class="submit">
                      <span class="fa fa-check" aria-hidden="true"></span>  {{__('update')}}
                    </button>
                    <a href="{{route('contracts.index')}}" class="return">
                      <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                    </a>
                  </div>
                  
                </form>
              </div>
            @endcan
          </div>

          </div> 
        </div>
      </div>
    </div>
@endsection
@push('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endpush