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
   @if($contractType == 'P')
    <div class="panel-heading"> <h3><b>Pre-Contrato / Nuevo Proyecto</b><h3></div>
   @elseif($contractType == 'S')
    <div class="panel-heading"> <h3><b>Pre-Contrato / Nuevo Servicio</b></h3></div>
    @endif
    <div class="panel-body">

      <form class="form" action="{{Route('precontracts.store')}}" method="POST">
        {{csrf_field()}}

        <select-country-office></select-country-office>

            <input type="hidden" name="contractType" value="{{ $contractType }}">

           <div class="row"></div>
           <search-client></search-client>
     <!--input Address-->      
          <div class="form-group col-xs-11">
                <label for="siteAddress">DIRECCIÓN</label>
                <input type="text" class="form-control" id="siteAddress" name="siteAddress">
           </div>

          <div class="form-group col-xs-7">
            <label for="projectTypeId">DESCRIPCION DE PROYECTO</label>
            <select class="form-control" name="projectTypeId" id="projectTypeId">
                @foreach($projects as $project)
                      <option value="{{$project->projectTypeId}}" > {{$project->projectTypeName}} </option>
                @endforeach
            </select>
          </div>

             <div class="form-group col-xs-7">
            <label for="serviceTypeId">TIPO DE PROYECTO</label>
            <select class="form-control" name="serviceTypeId" id="serviceTypeId">
                @foreach($services as $service)
                      <option value="{{$service->serviceTypeId}}" > {{$service->serviceTypeName}} </option>
                @endforeach
            </select>
          </div>

              <div class="col-xs-12">
                 <div class="form-group">
                   <label for="comment">{{__('initial_comment')}}</label>
                   <textarea class="form-control" id="comment" name="comment" value="{{ old('comment') }}" rows="3"></textarea>
                  </div>
              </div>
            <div class="col-xs-6">
               <div class="form-group">
              <label for="currencyName">{{__('currency')}}</label>
              <select class="form-control" name="currencyName" id="currencyName" value="{{ old('currencyName') }}">
                    <option value="USD" > USD </option>
                    <option value="BS" > BS </option>
              </select>
              </div>
            </div>


            <div class="col-xs-12 text-center">
              <button type="submit" class="btn btn-primary">
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
