@extends('layouts.master')

@section('content')
<h3><b>FACTURAS POR OFICINA</b></h3>

  <div class="col-xs-3 text-left">
    <h4 class="text-primary text-left">Total En Facturas: ${{$totalMontoFacturas}}</h4>
    <h4 class="text-success text-left">Total Cobrado: ${{$totalCobrado}}</h4>
    <h4 class="text-danger text-left">Total Por Cobrar: ${{$totalPorCobrar}}</h4>
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
          <a href="{{route('invoices.cancelled')}}" class="btn btn-danger text-center" >
                   Anuladas
         </a>
  </div>
  
    <div class="row">
        <div class="col-xs-12 ">

         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead  class="bg-success">
                <tr>
                 <th>#</th>
                 <th>INVOICE ID</th>
                 <th>CONTRATO</th>
                 <th>DIRECCION</th> 
                 <th>FECHA</th>
                 <th>DESCRIPCION DEL PROYECTO</th>
                 <th>TOTAL</th>
                 <th>BALANCE</th>
                 <th>CUOTAS</th>
                 <th>{{__('STATUS')}}</th> 
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
                   <td>{{$invoice->contract->siteAddress}}</td>
                   <td>{{$invoice->invoiceDate}}</td>
                   <td>{{$invoice->projectDescription->projectDescriptionName}}</td>
                   <td>{{$invoice->netTotal}}</td>
                   <td>{{$invoice->balance}}</td>
                   <td>{{$invoice->shareSucceed}}/{{$invoice->pQuantity}}</td>  
                   <td
                  @if($invoice->invStatusCode == App\Invoice::OPEN )
                      style="background-color: #2ab25b;color:white"  
                  @elseif($invoice->invStatusCode == App\Invoice::CLOSED )
                       style="background-color: #3c8ddc;color:white" 
                  @elseif($invoice->invStatusCode == App\Invoice::PAID )
                        style="background-color: #78341a;color:white" 
                   @elseif($invoice->invStatusCode == App\Invoice::COLLECTION )
                        style="background-color: #cbb956;color:white" 
                  @endif
                   >{{$invoice->invoiceStatus[0]->invStatusName}}</td> 
                   <td>

<<<<<<< HEAD
                @if($invoice->netTotal > 0) 
                   @can('BEE') 
                  <a href="{{route('invoices.payments', ['btnReturn' => 'mod_adm','id' => $invoice->invoiceId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                        <span class="fa fa-dollar-sign" aria-hidden="true"></span> 
                    </a> 
                    @endcan  
                @endif  
=======
                @can('BEE') 
                   @if($invoice->netTotal > 0) 
                  <a href="{{route('invoices.payments', ['btnReturn' => 'mod_adm','id' => $invoice->invoiceId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                        <span class="fa fa-dollar-sign" aria-hidden="true"></span> 
                    </a> 
                     @endif  
                 @endcan  
>>>>>>> aeefe06fae0c63d443ebaeb83e6950cd9ff2b9de

                 @can('BED') 
                   <a href="{{route('invoices.subcontractors', ['id' => $invoice->invoiceId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Subcontratistas">
                        <span class="fa fa-user" aria-hidden="true"></span> 
                    </a>   
                 @endcan    
             @if($invoice->invStatusCode == App\Invoice::OPEN )
       {{--             @if($invoice->contract->contractStatus == App\Contract::VACANT || $contract[0]->contractStatus == App\Contract::STARTED) --}}
                <btn-invoice-cancel invoice-id="{{$invoice->invoiceId}}" inv-id="{{$invoice->invId}}"></invoice-cancel>
                   @can('BEC')
                  <a href="{{route('invoicesDetails.index', ['btnReturn' => 'mod_adm','id' => $invoice->invoiceId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Renglones">
                        <span class="fa fa-book" aria-hidden="true"></span> 
                    </a>
                   @endif  
                   @can('BEA') 
                  <a href="{{route('invoices.edit', ['id' => $invoice->invoiceId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>  
                   @endif 
<<<<<<< HEAD

                <btn-invoice-cancel invoice-id="{{$invoice->invoiceId}}" inv-id="{{$invoice->invId}}"></invoice-cancel>
=======
>>>>>>> aeefe06fae0c63d443ebaeb83e6950cd9ff2b9de
             @endif 

             @can('BEB')
                <a href="{{route('reports.invoice', ['id' => $invoice->invoiceId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Ver">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a>
             @endif  
<<<<<<< HEAD
             @if($invoice->invStatusCode == App\Invoice::CLOSED )
                   <btn-invoice-collection invoice-id="{{$invoice->invoiceId}}" inv-id="{{$invoice->invId}}"></invoice-collection>
=======

             @if($invoice->invStatusCode == App\Invoice::CLOSED )
             <a href="{{route('saleNotes.getByInvoice', ['id' => $invoice->invoiceId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Notas de Venta">
                     <span class="fa fa-briefcase" aria-hidden="true"></span> 
                    </a>
                   <btn-invoice-collection invoice-id="{{$invoice->invoiceId}}" inv-id="{{$invoice->invId}}"></invoice-collection>

>>>>>>> aeefe06fae0c63d443ebaeb83e6950cd9ff2b9de
              @endif
   
                   
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
