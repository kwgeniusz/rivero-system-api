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
    <div class="panel-heading"> <h3><b>Editar Pre-Contrato</b></h3></div>
    <div class="panel-body">

  <form class="form" action="{{Route('precontracts.update',['id' => $precontract[0]->precontractId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('PUT')}}

        <div class="form-group col-xs-7">
           <label for="precontractNumber">N° </label>
           <input disabled type="text" class="form-control" id="precontractNumber" name="precontractNumber" value="{{ $precontract[0]->precontractId }}">
         </div>

         {{-- <select-country-office-edit country="{{$precontract[0]->countryId}}" office="{{$precontract[0]->officeId}}"></select-country-office-edit> --}}
           <input type="hidden" name="countryId" value="{{$precontract[0]->countryId}}">
           <input type="hidden" name="officeId" value="{{$precontract[0]->officeId}}">

           <div class="row"></div>
           <search-client url='E' c-id="{{$precontract[0]->clientId}}" c-name="{{$precontract[0]->client->clientName}}" c-address="{{$precontract[0]->siteAddress}}"></search-client>

     <!--input Address-->      
          <div class="form-group col-xs-11">
                <label for="siteAddress">DIRECCIÓN</label>
                <input type="text" class="form-control" id="siteAddress" name="siteAddress" value="{{ $precontract[0]->siteAddress }}">
           </div>
         <div class="form-group col-xs-7">
            <label for="projectDescriptionId">DESCRIPCION DE PROYECTO</label>
            <select class="form-control" name="projectDescriptionId" id="projectDescriptionId">
                @foreach($projectsD as $project)
                   @if ($project->projectDescriptionId == $precontract[0]->projectDescriptionId)
              <option value="{{$project->projectDescriptionId}}"selected> {{$project->projectDescriptionName}} </option>
                  @else
               <option value="{{$project->projectDescriptionId}}"> {{$project->projectDescriptionName}} </option>
               @endif
                @endforeach
            </select>
          </div>

         <div class="form-group col-xs-7">
            <label for="projectUseId">USO DE PROYECTO</label>
            <select class="form-control" name="projectUseId" id="projectUseId">
              @foreach($projectsU as $project)
                   @if ($project->projectUseId == $precontract[0]->projectUseId)
              <option value="{{$project->projectUseId}}"selected> {{$project->projectUseName}} </option>
                  @else
               <option value="{{$project->projectUseId}}"> {{$project->projectUseName}} </option>
                  @endif
                @endforeach
            </select>
          </div>

            <div class="col-xs-12">
             <div class="form-group">
                <label for="comment">{{__('initial_comment')}}</label>
                <textarea class="form-control" id="comment" name="comment" rows="3">{{ $precontract[0]->comment }}</textarea>
              </div>

      <div class="form-group col-xs-6">
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



          <div class="col-xs-12">
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

  </div>


@endsection
