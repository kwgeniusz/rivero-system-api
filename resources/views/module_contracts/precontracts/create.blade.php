@extends('layouts.master')

@section('content')
<div class="create">
    <form class="formulario" action="{{Route('precontracts.store')}}" method="POST">
    {{csrf_field()}}

    <h3><i class="fas fa-user-tie"></i> Editar Pre-contrato</h3>
    <div class="boxes"></div>

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

       <div style="width: 100%; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div class="inputother boxes2">
                  <label for="precontractNumber"><i class="fas fa-book"></i> N° PRECONTRATO</label>
                  <input type="text" style="cursor: no-drop" class="input-label" id="precontractNumber" name="precontractNumber" value="{{$preId}}" disabled="on">
                </div>
                <div class="inputother boxes2">
                  <label for="projectName"><i class="fas fa-file-signature"></i> NOMBRE DEL PROYECTO</label>
                  <input type="text" class="input-label" id="projectName" name="projectName" value="{{old('projectName')}}" placeholder="NOMBRE DEL PROYECTO">
                </div>
                <div class="inputother boxes2">
                  <label for="precontractDate"><i class="fas fa-calendar-alt"></i> FECHA</label>
                  <input class="input-label flatpickr" id="precontractDate" name="precontractDate" value="{{old('precontractDate')  }}">
                </div>

                <div class="inputother boxes2">
                <search-client pref-url='../../' ></search-client>
                </div>
              
                <div class="inputother boxes2">
                  <label for="contractType"><i class="fas fa-file-contract"></i> TIPO DE CONTRATO</label>
                  <select name="contractType" id="contractType">
                        <option value="P" selected>P</option>
                        <option value="S" >S</option>
                  </select>
                </div>
                <!--input Address-->      
                <div class="inputother boxes2">
                  <label for="propertyNumber"><i class="fas fa-home"></i> NUMERO DE LA PROPIEDAD</label>
                  <input type="text" class="input-label" id="propertyNumber" name="propertyNumber" value="{{old('propertyNumber') }}" placeholder="5924">
                </div>
                <div class="inputother boxes2">  
                  <label for="streetName"><i class="fas fa-road"></i> CALLE</label>
                  <input type="text" class="input-label" id="streetName" name="streetName" maxlength="20" value="{{old('streetName') }}" placeholder="AZALEA">
                </div>
                <div class="inputother boxes2">  
                  <label for="streetType"><i class="fas fa-street-view"></i> TIPO DE CALLE</label>
                  <input type="text" class="input-label" id="streetType" name="streetType" maxlength="10" value="{{old('streetType') }}" placeholder="LN">
                </div>
                <div class="inputother boxes2">  
                  <label for="suiteNumber"><i class="fas fa-building"></i> SUITE NUMBER</label>
                  <input type="text" class="input-label" id="suiteNumber" name="suiteNumber" maxlength="20" value="{{old('suiteNumber') }}" placeholder="SUITE 114 (Opcional)">
                </div>
                <div class="inputother boxes2">  
                  <label for="city"><i class="fas fa-map"></i> CIUDAD</label>
                  <input type="text" class="input-label" id="city" name="city" maxlength="20" value="{{old('city') }}" placeholder="DALLAS">
                </div>
                <div class="inputother boxes2">  
                  <label for="state"><i class="fas fa-compass"></i> ESTADO</label>
                  <input type="text" class="input-label" id="state" name="state" maxlength="20" value="{{old('state') }}" placeholder="TX">
                </div>
                <div class="inputother boxes2">  
                  <label for="zipCode"><i class="fas fa-envelope"></i> CODIGO POSTAL</label>
                  <input type="number" class="input-label" id="zipCode" name="zipCode" value="{{old('zipCode') }}" placeholder="75230">
                </div>
                <div class="inputother boxes2">
                  <label for="projectUseId">USO DEL PROYECTO</label>: 
                  <div class="input-label">
                    <input class="input" type="radio" name="projectUseId" id="inlineRadio1" value="1" >
                    <label style="width: 48%; margin-bottom: 0px;" for="inlineRadio1">COM</label>
                  </div>
                  <div>
                    <input class="input" type="radio" name="projectUseId" id="inlineRadio2" value="2">
                    <label style="width: 48%; margin-bottom: 0px;" for="inlineRadio2">RES</label>
                  </div>
                </div>
                <div class="inputother boxes2">
                  <label for="currencyId"><i class="fas fa-donate"></i> {{__('currency')}}</label>
                  <select name="currencyId" id="currencyId">
                    @foreach($currencies as $currency)
                        @if ($currency->currencyId ==old('currencyId'))
                    <option value="{{$currency->currencyId}}"selected> {{$currency->currencyName}} </option>
                        @else
                    <option value="{{$currency->currencyId}}"> {{$currency->currencyName}} </option>
                        @endif
                      @endforeach
                  </select>
                </div>
                <div class="input-label">  
                  <label for="comment"><i class="fas fa-comment-alt"></i> {{__('initial_comment')}}</label>
                  <textarea name="comment" id="comment" rows="10">{{old('comment') }}</textarea>
                </div>
                <div style="width: 100%; text-align: center;">
                  <button type="submit" class="submit">
                  <span class="fa fa-check" aria-hidden="true"></span>  Crear
                  </button>
                  <a class="return" href="{{route('precontracts.index')}}">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                  </a>
                </div>

               </div> 
              </form>
            </div>
 
@endsection
@push('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endpush