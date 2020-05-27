@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-warning col-xs-9">
    <div class="panel-heading"> <h3><b>¿Esta Seguro de Convertir esta Propuesta a Factura?</b></h3></div>
    <div class="panel-body">

      <form class="form-horizontal form-prevent-multiple-submits" action="{{Route('proposals.convertAdd',['id' => $proposal[0]->proposalId])}}" method="POST">
        {{csrf_field()}}

  <div class="form-group">
          <label class="col-sm-5 control-label">PROPUESTA </label>
          <div class="col-sm-7">
            <p class="form-control-static"># {{ $proposal[0]->propId }}</p>
          </div>
        </div>
      <div class="form-group">
          <label class="col-sm-5 control-label">FECHA</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $proposal[0]->proposalDate }}</p>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('client')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $proposal[0]->client->clientName }}</p>
          </div>
        </div>


        <div class="form-group">
          <label class="col-sm-5 control-label">{{__('address')}}</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $proposal[0]->contract->siteAddress }}</p>
          </div>
        </div>
       <div class="form-group">
          <label class="col-sm-5 control-label">CONDICION DE PAGO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $proposal[0]->paymentCondition->pCondName }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">TIPO DE CONTRATO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $proposal[0]->contract->contractType }}</p>
          </div>
        </div>
          <div class="form-group">
          <label class="col-sm-5 control-label">DESCRIPCION DE PROYECTO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $proposal[0]->projectDescription->projectDescriptionName }}</p>
          </div>
        </div>
         <div class="form-group">
          <label class="col-sm-5 control-label">USO DEL PROYECTO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $proposal[0]->contract->projectUse->projectUseName }}</p>
          </div>
        </div>
     

            <div class="text-center">
              <button type="submit" class="btn btn-success  button-prevent-multiple-submits">
                <span class="fa fa-sync" aria-hidden="true"></span>  Convertir
              </button>
               <a href="{{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
       </a>
            </div>
            </div>
          </form>


    </div>

  </div>

@endsection
