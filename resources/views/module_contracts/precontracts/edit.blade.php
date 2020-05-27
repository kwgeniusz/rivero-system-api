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

<div class="panel panel-success col-xs-12 col-lg-offset-1 col-lg-10">
    <div class="panel-heading text-center"> <h3><b>Editar Pre-Contrato</b></h3></div>
    <div class="panel-body">

  <form class="form" action="{{Route('precontracts.update',['id' => $precontract[0]->precontractId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}

         {{-- <select-country-office-edit country="{{$precontract[0]->countryId}}" office="{{$precontract[0]->officeId}}"></select-country-office-edit> --}}

           <input type="hidden" name="countryId" value="{{$precontract[0]->countryId}}">
           <input type="hidden" name="officeId" value="{{$precontract[0]->officeId}}">

        <div class="form-group col-lg-7">
           <label for="precontractNumber">N° PRECONTRATO</label>
           <input disabled type="text" class="form-control" id="precontractNumber" name="precontractNumber" value="{{ $precontract[0]->preId  }}">
         </div>

           <div class="row"></div>
           <div class="form-group col-lg-7">
                 <label for="projectName">NOMBRE DEL PROYECTO</label>
                <input type="text" value="{{ $precontract[0]->projectName }}" class="form-control" id="projectName" name="projectName">
           </div>

           <div class="row"></div>
                <div class="form-group col-lg-5">
                  <label for="precontractDate">FECHA</label>
                  <input class="form-control flatpickr"  id="precontractDate" name="precontractDate" value="{{$precontract[0]->precontractDate }}">
                </div>


           <div class="row"></div>
           <search-client pref-url='../../' c-id="{{$precontract[0]->clientId}}" c-name="{{$precontract[0]->client->clientName}}" c-address="{{$precontract[0]->siteAddress}}"></search-client>

          <div class="form-group col-lg-6">
            <label for="contractType">TIPO DE CONTRATO</label>
            <select class="form-control" name="contractType" id="contractType">
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

         <div class="form-group col-lg-7">
                <label for="propertyNumber">NUMERO DE LA PROPIEDAD</label>
                <input type="number" value="{{$precontract[0]->propertyNumber }}" class="form-control" id="propertyNumber" name="propertyNumber" placeholder="5924">
           </div>
           <div class="form-group col-lg-7">
                <label for="streetName">CALLE</label>
                <input type="text" maxlength="20" value="{{$precontract[0]->streetName }}" class="form-control" id="streetName" name="streetName" placeholder="AZALEA">
           </div>
            <div class="form-group col-lg-3">
                <label for="streetType">TIPO DE CALLE</label>
                <input type="text" maxlength="10" value="{{$precontract[0]->streetType }}" class="form-control" id="streetType" name="streetType" placeholder="LN">
           </div>
           <div class="form-group col-lg-6">
                <label for="suiteNumber">SUITE NUMBER</label>
                <input type="text" maxlength="20" value="{{$precontract[0]->suiteNumber }}" class="form-control" id="suiteNumber" name="suiteNumber" placeholder="SUITE 114 (Opcional)">
           </div>
            <div class="form-group col-lg-8">
                <label for="city">CIUDAD</label>
                <input type="text" maxlength="20" value="{{$precontract[0]->city }}" class="form-control" id="city" name="city" placeholder="DALLAS">
           </div>
           <div class="form-group col-lg-8">
                <label for="state">ESTADO</label>
                <input type="text" maxlength="20" value="{{$precontract[0]->state }}" class="form-control" id="state" name="state" placeholder="TX">
           </div>
                   <div class="row"></div>
            <div class="form-group col-lg-4">
                <label for="zipCode">CODIGO POSTAL</label>
                <input type="number"  value="{{$precontract[0]->zipCode }}" class="form-control" id="zipCode" name="zipCode" placeholder="75230">
           </div>
             <select-building-code 
             pref-Url='../../' 
             prop-building-code='{{$precontract[0]->buildingCodeId}}' 
             prop-building-code-group='{{$precontract[0]->groupId}}' 
             prop-project-use='{{$precontract[0]->projectUseId}}'></select-building-code>
  
        <div class="form-group col-lg-9">
            <label for="constructionType">TIPO DE CONSTRUCCION</label>
            <select class="form-control" name="constructionType" id="constructionType">
                 @if($precontract[0]->constructionType == 'TYPE I')
                      <option value="TYPE I" selected>TYPE I</option>
                      <option value="TYPE II" >TYPE II</option>
                      <option value="TYPE III" >TYPE III</option>
                      <option value="TYPE IV" >TYPE IV</option>
                 @elseif($precontract[0]->constructionType == 'TYPE II') 
                      <option value="TYPE I" >TYPE I</option>
                      <option value="TYPE II" selected>TYPE II</option>
                      <option value="TYPE III" >TYPE III</option>
                      <option value="TYPE IV" >TYPE IV</option>    
                 @elseif($precontract[0]->constructionType == 'TYPE III')
                      <option value="TYPE I" >TYPE I</option>
                      <option value="TYPE II" >TYPE II</option>
                      <option value="TYPE III" selected>TYPE III</option>
                      <option value="TYPE IV" >TYPE IV</option>     
                 @elseif($precontract[0]->constructionType == 'TYPE IV')
                      <option value="TYPE I" >TYPE I</option>
                      <option value="TYPE II" >TYPE II</option>
                      <option value="TYPE III" >TYPE III</option>
                      <option value="TYPE IV" selected>TYPE IV</option>     
                 @else
                      <option value="TYPE I" >TYPE I</option>
                      <option value="TYPE II" >TYPE II</option>
                      <option value="TYPE III" >TYPE III</option>
                      <option value="TYPE IV" >TYPE IV</option>     
                 @endif      
            </select>
          </div>

            <div class="col-lg-12">
             <div class="form-group">
                <label for="comment">{{__('initial_comment')}}</label>
                <textarea class="form-control" id="comment" name="comment" rows="3">{{ $precontract[0]->comment }}</textarea>
              </div>

      <div class="form-group col-lg-6">
            <label for="currencyId">{{__('currency')}}</label>
            <select class="form-control" name="currencyId" id="currencyId">
              @foreach($currencies as $currency)
                   @if ($currency->currencyId == $precontract[0]->currencyId)
              <option value="{{$currency->currencyId}}"selected> {{$currency->currencyName}} </option>
                  @else
               <option value="{{$currency->currencyId}}"> {{$currency->currencyName}} </option>
                  @endif
                @endforeach
            </select>
          </div>



          <div class="col-lg-12">
            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('update')}}
              </button>
              <a href="{{route('precontracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
          </div>

   </form>


    </div>



@endsection
