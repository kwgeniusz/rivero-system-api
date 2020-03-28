@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-xs-offset-1">
<div class="panel panel-danger col-xs-7">
    <div class="panel-heading"> 
      <h3><b><center>¿Esta Seguro de Eliminar la Propuesta?</center></b></h3>
    </div>
    <div class="panel-body">

      <form class="form-horizontal form-prevent-multiple-submits" action="{{Route('proposals.destroy',['id' => $proposal[0]->proposalId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('DELETE')}}

        <div class="row">
          <div class="form-group col-xs-4">
            <label for="precontractId">PROPUESTA:</label>
      {{ $proposal[0]->propId}}
          </div>
        </div>

              <div class="form-group">
                <label for="clientName">CLIENTE:</label>
               {{ $proposal[0]->precontract->client->clientName}}
              </div>

              <div class="form-group">
                <label for="precontractSiteAddress">DIRECCIÓN:</label>
               {{ $proposal[0]->address}}
              </div>

            <div class="form-group">
            <label for="paymentConditionId">CONDICION DE PAGO:</label>
               {{ $proposal[0]->paymentCondition->pCondName}}
          </div>

        <div class="row">
          <div class="form-group col-xs-8">
              <label for="preinvoiceDate">FECHA DE LA FACTURA:</label>
               {{ $proposal[0]->proposalDate}}
            </div>

         <div class="form-group col-xs-4">
            <label for="invoiceTaxPercent">IMPUESTO (%):</label>
               {{ $proposal[0]->taxPercent}}
           </div>
        </div>


            <div class="text-center">
              <button type="submit" class="btn btn-danger  button-prevent-multiple-submits">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
              </button>
            <a href="{{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>
    
          </form>
    </div>

  </div>
</div>

@endsection
