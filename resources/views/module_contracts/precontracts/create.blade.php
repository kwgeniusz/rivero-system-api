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
    <div class="panel-heading"> <h3><b>Nuevo Pre-contrato</b><h3></div>
    <div class="panel-body">

      <form class="form  form-prevent-multiple-submits" action="{{Route('precontracts.store')}}" method="POST">
        {{csrf_field()}}

         <!-- <select-country-office></select-country-office>  -->

        <div class="row"></div>
         <div class="form-group col-xs-3">
            <label for="preId">N° PRECONTRATO</label>
            <input type="text" class="form-control" id="preId" name="preId" value="{{ $preId}}" disabled="on">
          </div>

           <div class="row"></div>
                <div class="form-group col-xs-5">
                  <label for="precontractDate">FECHA</label>
                  <input class="form-control flatpickr" id="precontractDate" name="precontractDate" value="{{ old('precontractDate') }}">
                </div>

           <div class="row"></div>
           <search-client pref-url='../'></search-client>

           <div class="form-group col-xs-6">
            <label for="contractType">TIPO DE CONTRATO</label>
            <select class="form-control" name="contractType" id="contractType">
                <option value="P" >P</option>
                <option value="S" >S</option>
            </select>
          </div>
     <!--input Address-->   

          <div class="form-group col-xs-7">
                <label for="propertyNumber">NUMERO DE LA PROPIEDAD</label>
                <input type="number" value="{{ old('propertyNumber') }}" class="form-control" id="propertyNumber" name="propertyNumber" placeholder="5924">
           </div>
           <div class="form-group col-xs-7">
                <label for="streetName">CALLE</label>
                <input type="text" maxlength="20" value="{{ old('streetName') }}" class="form-control" id="streetName" name="streetName" placeholder="AZALEA">
           </div>
            <div class="form-group col-xs-3">
                <label for="streetType">TIPO DE CALLE</label>
                <input type="text" maxlength="10" value="{{ old('streetType') }}" class="form-control" id="streetType" name="streetType" placeholder="LN">
           </div>
           <div class="form-group col-xs-6">
                <label for="suiteNumber">SUITE NUMBER</label>
                <input type="text" maxlength="20" value="{{ old('suiteNumber') }}" class="form-control" id="suiteNumber" name="suiteNumber" placeholder="SUITE 114 (Opcional)">
           </div>
            <div class="form-group col-xs-8">
                <label for="city">CIUDAD</label>
                <input type="text" maxlength="20" value="{{ old('city') }}" class="form-control" id="city" name="city" placeholder="DALLAS">
           </div>
           <div class="form-group col-xs-8">
                <label for="state">ESTADO</label>
                <input type="text" maxlength="20" value="{{ old('state') }}" class="form-control" id="state" name="state" placeholder="TX">
           </div>
                   <div class="row"></div>
            <div class="form-group col-xs-4">
                <label for="zipCode">CODIGO POSTAL</label>
                <input type="number" value="{{ old('zipCode') }}" class="form-control" id="zipCode" name="zipCode" placeholder="75230">
           </div>

             <select-building-code pref-Url='../'></select-building-code>

              <div class="col-xs-12">
                 <div class="form-group">
                   <label for="comment">{{__('initial_comment')}}</label>
                   <textarea class="form-control" id="comment" name="comment"  rows="3">{{old('comment')}}</textarea>
                  </div>
              </div>

         <div class="form-group col-xs-6">
            <label for="currencyId">{{__('currency')}}</label>
            <select class="form-control" name="currencyId" id="currencyId">
                @foreach($currencies as $currency)
                      <option value="{{$currency->currencyId}}" > {{$currency->currencyName}} </option>
                @endforeach
            </select>
          </div>


            <div class="col-xs-12 text-center">
              <button type="submit" class="btn btn-primary  button-prevent-multiple-submits">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('submit')}}
              </button>
              <a href="{{route('precontracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>

          </form>


    </div>

  </div>

@endsection
