@extends('layouts.master')
@section('content')
{{-- @php use AppApp\Receivable; @endphp --}}
  <div class="create">
    <div class="formulario">
      <div>
        <h3>FACTURA</h3>
        <div class="boxes" style="padding-top: 10px;">
          <div class="table-responsive tableother">
            {{-- {{$invoice[0]->shareSucceed}}<BR><BR> --}}
            {{-- {{$invoice[0]->sharePending}} --}}
            <table class="table table-striped table-bordered text-center">
              <thead>
                <tr class="bg-success">
                  <th>N° FACTURA</th>
                  <th>CLIENTE</th>
                  <th>CONTRATO</th>
                  <th>DIRECCIÓN</th>
                  <th>FECHA</th>
                  <th>DESCRIPCION DEL PROYECTO</th>
                  <th>TOTAL</th>
                  <th>BALANCE</th>
                  <th>CUOTAS</th>
                  <th>NOTAS </th>
                  <th>{{__('STATUS')}}</th> 
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{$invoice[0]->invId}} </td>
                  <td>{{$invoice[0]->client->clientName}} </td>
                  <td>{{$invoice[0]->contract->contractNumber}} </td>
                  <td>{{$invoice[0]->contract->siteAddress}} </td>
                  <td>{{$invoice[0]->invoiceDate}} </td>
                  <td>{{$invoice[0]->projectDescription->projectDescriptionName}}</td>
                  <td>{{$invoice[0]->netTotal}}</td>
                  <td>{{$invoice[0]->balanceTotal}}</td>
                  <td>{{$invoice[0]->shareSucceed->count()}}/{{$invoice[0]->pQuantity}}</td>  
                  <td>
                    @if($invoice[0]->invStatusCode == App\Invoice::CLOSED or $invoice[0]->invStatusCode == App\Invoice::PAID )
                      <a href="{{route('invoiceSaleNotes.getAll', ['id' => $invoice[0]->invoiceId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Notas de Venta">
                        <span class="fa fa-briefcase" aria-hidden="true"></span> 
                      </a>
                    @endif
                  </td>
                  <td
                    @if($invoice[0]->invStatusCode == App\Invoice::OPEN )
                        style="background-color: #2ab25b;color:white"  
                    @elseif($invoice[0]->invStatusCode == App\Invoice::CLOSED )
                        style="background-color: #3c8ddc;color:white" 
                    @elseif($invoice[0]->invStatusCode == App\Invoice::PAID )
                          style="background-color: #78341a;color:white" 
                    @elseif($invoice[0]->invStatusCode == App\Invoice::COLLECTION )
                          style="background-color: #cbb956;color:white" 
                    @endif
                  >
                    <a style="color: white;" href="{{route('reports.invoice', ['id' => $invoice[0]->invoiceId])}}">
                      <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                      {{$invoice[0]->invoiceStatus[0]->invStatusName}} 
                    </a>
                  </td> 
                </tr>
              </tbody>
            </table>
          </div>
          <hr>
          <div class="input-label boxes2">
            <h4 style="font-size: 25px; font-weight: 700; text-align: center;">CUOTAS</h4>
            @if($invoice[0]->contract->contractStatus <> App\Contract::FINISHED && $invoice[0]->contract->contractStatus <> App\Contract::CANCELLED)
              @if($invoice[0]->invStatusCode <> App\Invoice::PAID  && $invoice[0]->invStatusCode <> App\Invoice::CANCELLED)
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
                  <form class="input-label" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; flex-direction: column;" action="{{Route('invoices.paymentsAdd')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="invoiceId" value="{{$invoice[0]->invoiceId}}">
                    <div class="inputother boxes2">
                      <label for="amount" >MONTO</label>
                      <input type="number" min='0.01' step="0.01" class="input-label" id="amount" name="amount" required autocomplete="off">
                    </div>
                    <div style="width: 100%; display: flex; justify-content: left; align-items: flex-start;"> 
                      <button type="submit" class="submit button-prevent-multiple-submits" style="background: green; margin-top: 0px;">
                        <span class="fa fa-plus" aria-hidden="true"></span>
                        Agregar Cuota
                      </button>
                    </div>
                  </form>
              @endif
            @endif
          </div>
          <br>
          <div class="table-responsive tableother">
            <table class="table table-striped table-bordered text-center">
              <thead>
                <tr class="bg-info">
                  <th>#</th>
                  {{-- <th>FECHA DE CREACION</th> --}}
                  <!-- <th>MONTO INICIAL</th> -->
                  <th>CUOTA</th>
                  <th>MONTO PAGADO</th>
                  <th colspan="1">ACCIONES</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $acum = 0;
                  $total = 0; 
                ?>
                @foreach($payments as $receivable)  
                  <tr>
                    <td 
                    @if($receivable->recStatusCode == App\Receivable::STATELESS)
                      style="background-color: #3c8ddc;color:white" 
                    @elseif($receivable->recStatusCode == App\Receivable::PROCESS)
                      style="background-color: #cbb956;color:white" 
                    @elseif($receivable->recStatusCode == App\Receivable::DECLINED) 
                      style="background-color: #78341a;color:white" 
                    @elseif($receivable->recStatusCode == App\Receivable::SUCCESS)
                      style="background-color: #2ab25b;color:white" 
                    @elseif($receivable->recStatusCode == App\Receivable::ANNULLED)
                      style="background-color: grey;color:white" 
                    @endif >{{ $acum = $acum +1 }}
                    </td>
                    <td>{{$receivable->amountDue}}</td>
                    <td>{{$receivable->amountPaid}}</td>
                    <td>
                      {{-- {{$receivable->recStatusCode}} - {{$invoice[0]->contract->contractStatus}} --}}
                      @if($invoice[0]->contract->contractStatus <> App\Contract::FINISHED && $invoice[0]->contract->contractStatus <> App\Contract::CANCELLED)
                        {{-- EL primer if es para verificar que son opciones de la cuota que lo corresponde a pagar a cliente --}}
                        @if($receivable->paymentInvoiceId == $currentShare) 
                          @if($receivable->recStatusCode == App\Receivable::STATELESS || $receivable->recStatusCode == App\Receivable::DECLINED) 
                            <form-modal-charge r-id="{{$receivable->receivableId}}" country-id="{{$receivable->countryId}}"></form-modal-charge>
                          @endif
                          @if($receivable->recStatusCode == App\Receivable::PROCESS) 
                            <confirm-payment r-id="{{$receivable->receivableId}}" country-id="{{$receivable->countryId}}"></confirm-payment>
                          @endif
                        @endif
                        @if($receivable->recStatusCode == App\Receivable::STATELESS || $receivable->recStatusCode == App\Receivable::DECLINED)
                          <a href="{{route('invoices.paymentsRemove', [
                            'id' => $receivable->paymentInvoiceId,
                            'invoiceId' =>$invoice[0]->invoiceId]) }}" class="return link-prevent-multiple-submits" style="padding: 2px 5px; background: #d60101;">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                          </a>
                        @endif
                      @endif
                      @if($receivable->recStatusCode != App\Receivable::STATELESS && 
                        $receivable->recStatusCode != App\Receivable::ANNULLED)  
                        <a href="{{route('reports.printReceipt', [
                          'receivableId' => $receivable->receivableId]) }}" class="submit" style="padding: 5px 10px;">
                          <span class="fa fa-file-invoice" aria-hidden="true"></span>  Recibo
                        </a>
                      @endif 
                      {{--           @if($receivable->recStatusCode == App\Receivable::STATELESS)
                        @if($invoice[0]->contract->contractStatus <> App\Contract::FINISHED && $invoice[0]->contract->contractStatus <> App\Contract::CANCELLED)
                          <a href="{{route('invoices.paymentsRemove', [
                            'id' => $paymentInvoiceId,
                            'invoiceId' =>$invoice[0]->invoiceId]) }}" class="return link-prevent-multiple-submits" style="padding: 5px 10px; background: #d60101;">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                          </a>
                        @endif
                      @endif --}}
                    </td>
                  </tr>
                  @php  
                    $total = $total + $receivable->amountDue; 
                    $total = number_format((float)$total, 2, '.', '');
                  @endphp 
                @endforeach
                  <tr>
                    <td></td>
                    <td><h4 class="text-info" align="center" >Suma de Cuotas: {{$total}} </h3></td>
                    <td><h4 class="text-danger" align="center" >Restante a Pagar: {{$invoice[0]->balanceTotal}}</h4></td>
                    <td></td>
                  </tr>
              </tbody>
            </table>
          </div>
          <div style="width: 100%; display: flex; justify-content: space-between; align-items: flex-start;">
            <a href="{{route('reports.statement', ['id' => $invoice[0]->invoiceId])}}" class="return buttonmovil" style="background: #0062be;" data-toggle="tooltip" data-placement="top">  <span class="fa fa-file-pdf" aria-hidden="true"></span> Estado de cuenta
            </a>
            <a href="{{route('reports.invoice', ['id' => $invoice[0]->invoiceId])}}" class="return buttonmovil" style="background: #ff7300;" data-toggle="tooltip" data-placement="top" title="Imprimir">
              <span class="fa fa-file-pdf" aria-hidden="true"></span> 
              Factura
            </a>
            @if($btnReturn == 'mod_cont')
              <a href="{{route('invoices.index',['id' => $invoice[0]->contract->contractId])}}" class="return buttonmovil">
                <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            @elseif($btnReturn == 'mod_adm')
              <a href="{{route('invoices.all')}}" class="return buttonmovil">
                <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('styles')
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endpush
