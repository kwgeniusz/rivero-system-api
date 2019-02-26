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


         <select-country-office-edit country="{{$precontract[0]->countryId}}" office="{{$precontract[0]->officeId}}"></select-country-office-edit>

           <div class="row"></div>
           <search-client url='E' c-id="{{$precontract[0]->clientId}}" c-name="{{$precontract[0]->client->clientName}}" c-address="{{$precontract[0]->siteAddress}}"></search-client>

          <div class="form-group col-xs-7">
            <label for="projectTypeId">DESCRIPCION DE PROYECTO</label>
            <select class="form-control" name="projectTypeId" id="projectTypeId">
                @foreach($projects as $project)
                   @if ($project->projectTypeId == $precontract[0]->projectTypeId)
              <option value="{{$project->projectTypeId}}"selected> {{$project->projectTypeName}} </option>
                  @else
               <option value="{{$project->projectTypeId}}"> {{$project->projectTypeName}} </option>
               @endif
                @endforeach
            </select>
          </div>

         <div class="form-group col-xs-7">
            <label for="serviceTypeId">TIPO DE PROYECTO</label>
            <select class="form-control" name="serviceTypeId" id="serviceTypeId">
              @foreach($services as $service)
                   @if ($service->serviceTypeId == $precontract[0]->serviceTypeId)
              <option value="{{$service->serviceTypeId}}"selected> {{$service->serviceTypeName}} </option>
                  @else
               <option value="{{$service->serviceTypeId}}"> {{$service->serviceTypeName}} </option>
                  @endif
                @endforeach
            </select>
          </div>

            <div class="col-xs-6">
               <div class="form-group">
              <label for="currencyName">{{__('currency')}}</label>
              <select class="form-control" name="currencyName" id="currencyName">
                   @if($precontract[0]->currencyName == "USD")
                    <option value="USD" selected> USD </option>
                    <option value="BS" > BS </option>
                    @else
                    <option value="USD"> USD </option>
                    <option value="BS" selected> BS </option>
                    @endif
              </select>
              </div>
            </div>



          <div class="col-xs-12">
            <div class="text-center">
              <button type="submit" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  {{__('submit')}}
              </button>
              <a href="{{route('precontracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
          </div>

   </form>


    </div>

  </div>


@endsection
