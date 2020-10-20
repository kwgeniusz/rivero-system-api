@extends('layouts.master')

@section('content')
<h3><b>FACTURAS ANULADAS</b></h3>

 {{--  <div class="col-xs-3 text-left">
    <h4 class="text-primary text-left">Total En Facturas: ${{$totalMontoFacturas}}</h4>
    <h4 class="text-suext-left">Total Cobrado: ${{$totalCobrado}}</h4>
    <h4 class="text-danger text-lefccess tt">Total Por Cobrar: ${{$totalPorCobrar}}</h4>
    <h4 class="text-warning text-left">Collections: ${{$totalCollections}}</h4>
  </div>

<div class="col-xs-6 text-center">
 <form class="form" action="{{Route('invoices.filtered')}}" method="POST">
        {{ csrf_field() }}
          <label for="date1">BUSQUEDA GENERAL:</label>
  <div class="col-xs-12">
          <div class="form-group col-lg-6">
              <select class="form-control" name="filterBy" id="filterBy">
                   <option value="invId" >N° Factura</option>
                   <option value="contractNumber" >Cod. de contrato </option>
                   <option value="siteAddress" >Direccion </option>
                   <option value="clientCode" >Cod. de cliente</option>
                   <option value="clientName" >Nombre de cliente</option>
                   <option value="clientPhone" >Telefono de cliente</option>
              </select>
            </div>
          <div class="form-group col-lg-6">
              <input type="text" class="form-control" name="textToFilter" id="textToFilter" autocomplete="off" placeholder="Escriba un valor a buscar">
            </div>
   </div>            
  <div class="col-xs-12">
          <div class="form-group col-lg-6">
              <label for="date1">DESDE:</label> <input class="form-control flatpickr" id="date1" name="date1" value="{{ old('date1') }}" required> 
            </div>
            <div class="form-group col-lg-6">
              <label for="date2">HASTA:</label>
              <input class="form-control flatpickr" id="date2" name="date2" value="{{ old('date2') }}" required> 
            </div>
    </div>
    <div class="col-xs-12">
      <button type="submit" class="btn btn-primary">
        <span class="fa fa-search" aria-hidden="true"></span> Buscar
      </button>
    </div>
 </form>
</div>

  <div class="col-xs-3 text-right">
   <b> Opciones: </b> 
          <a href="" class="btn btn-danger text-center" >
                   Anuladas
         </a>
  </div> --}}
<div class="text-center">
    <a href="{{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
    </a>
</div>
<br>
    <div class="row">
        <div class="col-xs-12 ">

         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead  class="bg-danger">
                <tr>
                 <th>#</th>
                 <th>INVOICE ID</th>
                 <th>CONTRATO</th>
                 <th>CLIENTE</th>
                 <th>DIRECCION</th> 
                 <th>FECHA</th>
                 <th>DESCRIPCION DEL PROYECTO</th>
                 <th>TOTAL</th>
                 <th>BALANCE</th>
                 <th>CUOTAS</th>
                 {{-- <th>{{__('STATUS')}}</th>  --}}
                 <th>{{__('actions')}}</th> 
                 </th>
                </tr>
            </thead>
                <tbody>
        {{-- IMPRESION DE INVOICES --}}
                @php $acum = 0; @endphp
                @foreach($invoices as $invoice)
                <tr>
                   <td>{{ $acum = $acum +1 }}</td>
                   <td>{{$invoice->invId}}</td> 
                   <td>{{$invoice->contract->contractNumber}}</td> 
                   <td>{{$invoice->client->clientName}}</td> 
                   <td>{{$invoice->contract->siteAddress}}</td>
                   <td>{{$invoice->invoiceDate}}</td>
                   <td>{{$invoice->projectDescription->projectDescriptionName}}</td>
                   <td>{{$invoice->netTotal}}</td>
                   <td>{{$invoice->balanceTotal}}</td>
                   <td>{{$invoice->shareSucceed->count()}}/{{$invoice->pQuantity}}</td>  
                   <td>
                 @can('BEE') 
                  <a href="{{route('invoices.payments', ['btnReturn' => 'mod_adm','id' => $invoice->invoiceId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                        <span class="fa fa-dollar-sign" aria-hidden="true"></span> 
                    </a> 
                    @endcan  

                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
                {{-- {{$invoices->render()}} --}}
        </div>

        </div>
        </div>




@endsection
