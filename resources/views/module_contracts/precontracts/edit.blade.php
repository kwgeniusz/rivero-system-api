@extends('layouts.master')

@section('content')
<div class="create">
  <form  class="formulario" action="{{Route('precontracts.update',['id' => $precontract[0]->precontractId])}}" method="POST">
    <div>

    <h3><i class="fas fa-user-tie"></i> Editar Pre-contrato</h3>
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
        </div>
  </div>

<div class="panel panel-success col-xs-12 col-lg-offset-1 col-lg-10">
    <div class="panel-heading text-center"> <h3><b>Editar Pre-Contrato</b></h3></div>
    <div class="panel-body">

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  @can('BBB') 
    <li role="presentation" class="active"><a href="#basicInformation" aria-controls="basicInformation" role="tab" data-toggle="tab">Informacion Basica</a></li>
  @endcan
  @can('BBBA') 
   <li role="presentation"><a href="#IBC" aria-controls="IBC" role="tab" data-toggle="tab">International Building Code</a></li>
   @endcan

</ul>

  <br>

<!-- Tab panes -->
<div class="tab-content">
@can('BBB') 
  <div role="tabpanel" class="tab-pane active" id="basicInformation">
   
  <form class="form" action="{{Route('precontracts.update',['id' => $precontract[0]->precontractId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}
         {{-- <select-country-office-edit country="{{$precontract[0]->countryId}}" office="{{$precontract[0]->companyId}}"></select-country-office-edit> --}}
          <input type="hidden" name="countryId" value="{{$precontract[0]->countryId}}">
          <input type="hidden" name="companyId" value="{{$precontract[0]->companyId}}">
      
        <div class="inputother boxes2">
          <label for="precontractNumber"><i class="far fa-id-card"></i> N° PRECONTRATO</label>
          <input type="text" style="cursor: no-drop" class="input-label" id="precontractNumber" name="precontractNumber" value="{{ $precontract[0]->preId  }}" disabled="on">
        </div>

        <div class="inputother boxes2">
                <label for="projectName"><i class="fas fa-user-friends"></i> NOMBRE DEL PROYECTO</label>
                <input type="text" class="input-label" id="projectName" name="projectName" value="{{ $precontract[0]->projectName  }}" placeholder="NOMBRE DEL PROYECTO">
      </div>

        <div class="inputother boxes2">
          <label for="precontractDate"><i class=""></i> FECHA</label>
          <input class="input-label flatpickr" id="precontractDate" name="precontractDate" value="{{ $precontract[0]->precontractDate  }}">
        </div>

        <search-client pref-url='../../' c-id="{{$precontract[0]->clientId}}" c-name="{{$precontract[0]->client->clientName}}" c-address="{{$precontract[0]->siteAddress}}"></search-client>
        
        <div class="inputother boxes2">
          <label for="contractType"><i class=""></i> TIPO DE CONTRATO</label>
          <select name="contractType" id="contractType">
                 @foreach($currencies as $currency)
                   @if ('P' == $precontract[0]->contractType)
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
          <label for="propertyNumber"><i class=""></i> NUMERO DE LA PROPIEDAD</label>
          <input type="text" class="input-label" id="propertyNumber" name="propertyNumber" value="{{$precontract[0]->propertyNumber }}" placeholder="5924">
        </div>
        <div class="inputother boxes2">  
          <label for="streetName"><i class=""></i> CALLE</label>
          <input type="text" class="input-label" id="streetName" name="streetName" maxlength="20" value="{{$precontract[0]->streetName }}" placeholder="AZALEA">
        </div>
        <div class="inputother boxes2">  
          <label for="streetType"><i class=""></i> TIPO DE CALLE</label>
          <input type="text" class="input-label" id="streetType" name="streetType" maxlength="10" value="{{$precontract[0]->streetType }}" placeholder="LN">
        </div>
        <div class="inputother boxes2">  
          <label for="suiteNumber"><i class=""></i> SUITE NUMBER</label>
          <input type="text" class="input-label" id="suiteNumber" name="suiteNumber" maxlength="20" value="{{$precontract[0]->suiteNumber }}" placeholder="SUITE 114 (Opcional)">
        </div>
        <div class="inputother boxes2">  
          <label for="city"><i class=""></i> CIUDAD</label>
          <input type="text" class="input-label" id="city" name="city" maxlength="20" value="{{$precontract[0]->city }}" placeholder="DALLAS">
        </div>
        <div class="inputother boxes2">  
          <label for="state"><i class=""></i> ESTADO</label>
          <input type="text" class="input-label" id="state" name="state" maxlength="20" value="{{$precontract[0]->state }}" placeholder="TX">
        </div>
        <div class="inputother boxes2">  
          <label for="zipCode"><i class=""></i> CODIGO POSTAL</label>
          <input type="number" class="input-label" id="zipCode" name="zipCode" value="{{$precontract[0]->zipCode }}" placeholder="75230">
        </div>

        <div class="row"></div>
       <div class="form-group col-lg-8">
       <label for="projectUseId">USO DEL PROYECTO</label>: 

       <input class="form-check-input" type="radio" name="projectUseId" id="inlineRadio1" value="1" {{ ($precontract[0]->projectUseId == '1')? "checked" : "" }}>
       <label class="form-check-label" for="inlineRadio1">COM</label>
    
        <input class="form-check-input" type="radio" name="projectUseId" id="inlineRadio2" value="2" {{ ($precontract[0]->projectUseId == '2')? "checked" : "" }}>
        <label class="form-check-label" for="inlineRadio2">RES</label>
      </div>

        <div class="textarea">  
          <label for="comment"><i class=""></i> {{__('initial_comment')}}</label>
          <textarea name="comment" id="comment" rows="10">"{{$precontract[0]->comment }}"</textarea>
        </div>

        <div class="inputother boxes2">
          <label for="currencyId"><i class=""></i> {{__('currency')}}</label>
          <select name="currencyId" id="currencyId">
              @foreach($currencies as $currency)
                   @if ($currency->currencyId == $precontract[0]->currencyId)
              <option value="{{$currency->currencyId}}"selected> {{$currency->currencyName}} </option>
                  @else
               <option value="{{$currency->currencyId}}"> {{$currency->currencyName}} </option>
                  @endif
                @endforeach
            </select>
          </div>

           <div style="width: 100%; text-align: center;">

               <button type="submit" class="submit">
               <span class="fa fa-check" aria-hidden="true"></span>  {{__('update')}}
               </button>

                <a href="{{route('precontracts.index')}}">
                 <button class="return">
                 <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                 </button>
                </a>
    </div>
          </div>

   </form>
  </div>
@endcan

@can('BBBA') 
  <div role="tabpanel" class="tab-pane" id="IBC">
  <form class="form" action="{{Route('precontracts.updateIbc',['id' => $precontract[0]->precontractId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}

           <select-building-code 
             pref-Url='../../' 
             prop-building-code='{{$precontract[0]->buildingCodeId}}' 
             prop-building-code-group='{{$precontract[0]->groupId}}' 
             prop-project-use='{{$precontract[0]->projectUseId}}'
             prop-construction-type='{{$precontract[0]->constructionType}}'></select-building-code> 

          <div class="col-lg-12 text-center">
           <div style="width: 100%; text-align: center;">
            <button type="submit" class="submit">
              <span class="fa fa-check" aria-hidden="true"></span>  {{__('update')}}
           </button>
           <a href="{{route('precontracts.index')}}">
            <button class="return">
               <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
           </button>
            </a>
    </div>
            </div>
  </form>
  </div>
@endcan
    </div>

  </div>
</div>
@endsection

@push('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endpush