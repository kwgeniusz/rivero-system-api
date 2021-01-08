@extends('layouts.master')

@section('content')
<div class="create">
  <form  class="formulario" action="{{Route('precontracts.store')}}" method="POST">
    <div>
    <h3><i class="fas fa-user-tie"></i> Nuevo Pre-contrato</h3>
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
        {{csrf_field()}}
        <div class="inputother boxes2">
          <label for="preId"><i class="far fa-id-card"></i> N° PRECONTRATO</label>
          <input type="text" style="cursor: no-drop" class="input-label" id="preId" name="preId" value="{{ $preId}}" disabled="on">
        </div>
        <div class="inputother boxes2">
                <label for="projectName"><i class="fas fa-user-friends"></i> NOMBRE DEL PROYECTO</label>
                <input type="text" class="input-label" id="projectName" name="projectName" value="{{ old('projectName') }}" placeholder="NOMBRE DEL PROYECTO">
              </div>
        <div class="inputother boxes2">
          <label for="precontractDate"><i class=""></i> FECHA</label>
          <input class="input-label flatpickr" id="precontractDate" name="precontractDate" value="{{ old('precontractDate') }}">
        </div>
        <search-client pref-url='../'></search-client>
        <div class="inputother boxes2">
          <label for="contractType"><i class=""></i> TIPO DE CONTRATO</label>
          <select name="contractType" id="contractType">
              <option value="P" >P</option>
              <option value="S" >S</option>
          </select>
        </div>
        <div class="inputother boxes2">
          <label for="propertyNumber"><i class=""></i> NUMERO DE LA PROPIEDAD</label>
          <input type="text" class="input-label" id="propertyNumber" name="propertyNumber" value="{{ old('propertyNumber') }}" placeholder="5924">
        </div>
        <div class="inputother boxes2">  
          <label for="streetName"><i class=""></i> CALLE</label>
          <input type="text" class="input-label" id="streetName" name="streetName" maxlength="20" value="{{ old('streetName') }}" placeholder="AZALEA">
        </div>
        <div class="inputother boxes2">  
          <label for="streetType"><i class=""></i> TIPO DE CALLE</label>
          <input type="text" class="input-label" id="streetType" name="streetType" maxlength="10" value="{{ old('streetType') }}" placeholder="LN">
        </div>
        <div class="inputother boxes2">  
          <label for="suiteNumber"><i class=""></i> SUITE NUMBER</label>
          <input type="text" class="input-label" id="suiteNumber" name="suiteNumber" maxlength="20" value="{{ old('suiteNumber') }}" placeholder="SUITE 114 (Opcional)">
        </div>
        <div class="inputother boxes2">  
          <label for="city"><i class=""></i> CIUDAD</label>
          <input type="text" class="input-label" id="city" name="city" maxlength="20" value="{{ old('city') }}" placeholder="DALLAS">
        </div>
        <div class="inputother boxes2">  
          <label for="state"><i class=""></i> ESTADO</label>
          <input type="text" class="input-label" id="state" name="state" maxlength="20" value="{{ old('state') }}" placeholder="TX">
        </div>
        <div class="inputother boxes2">  
          <label for="zipCode"><i class=""></i> CODIGO POSTAL</label>
          <input type="number" class="input-label" id="zipCode" name="zipCode" value="{{ old('zipCode') }}" placeholder="75230">
        </div>
        <select-building-code pref-Url='../'></select-building-code>
        <div class="inputother boxes2">
          <label for="constructionType"><i class=""></i> TIPO DE CONTRUCCION</label>
            <select class="form-control" name="constructionType" id="constructionType">
              <option value="TYPE I" >TYPE I</option>
              <option value="TYPE II" >TYPE II</option>
              <option value="TYPE III" >TYPE III</option>
              <option value="TYPE IV" >TYPE IV</option>
              <option value="TYPE V" >TYPE V</option>
            </select>
        </div>
        <div class="textarea">  
          <label for="comment"><i class=""></i> {{__('initial_comment')}}</label>
          <textarea name="comment" id="comment" rows="10">{{ old('comment') }}</textarea>
        </div>
        <div class="inputother boxes2">
          <label for="currencyId"><i class=""></i> {{__('currency')}}</label>
          <select name="currencyId" id="currencyId">
                @foreach($currencies as $currency)
                      <option value="{{$currency->currencyId}}" > {{$currency->currencyName}} </option>
                @endforeach
            </select>
        </div>
      </div>
    </div>
    <div style="width: 100%; text-align: center;">
      <button type="submit" class="submit">
        <span class="fa fa-check" aria-hidden="true"></span>  {{__('submit')}}
      </button>
      <a href="{{route('precontracts.index')}}">
        <button class="return">
          <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
        </button>
      </a>
    </div>
  </form>
</div>
@endsection
@push('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endpush