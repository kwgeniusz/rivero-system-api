@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-lg-7 col-lg-offset-1">
<div class="panel panel-danger ">
    <div class="panel-heading text-center"> <h3><b>¿Esta seguro que desea cancelar esta Factura?</b></h3></div>
    <div class="panel-body">

      <form class="form-horizontal form-prevent-multiple-submits" action="{{Route('invoices.cancel',['invoiceId' => $invoice[0]->invoiceId])}}" method="POST">
        {{csrf_field()}}
        {{method_field('DELETE')}}

         <div class="form-group">
          <label class="col-sm-5 control-label">FACTURA</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $invoice[0]->invId }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">CONTROL NUMBER</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $invoice[0]->contract->contractNumber }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">DIRECCION</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $invoice[0]->contract->siteAddress }}</p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-5 control-label">FECHA</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $invoice[0]->invoiceDate }}</p>
          </div>
        </div>
         <div class="form-group">
          <label class="col-sm-5 control-label">USO DE PROYECTO</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $invoice[0]->projectDescription->projectDescriptionName }}</p>
          </div>
        </div>
          <div class="form-group">
          <label class="col-sm-5 control-label">TOTAL</label>
          <div class="col-sm-7">
            <p class="form-control-static">{{ $invoice[0]->netTotal}}</p>
          </div>
        </div>

  

 
         

            <div class="col-xs-12 text-center">
              <button type="submit" class="btn btn-danger  button-prevent-multiple-submits">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
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
