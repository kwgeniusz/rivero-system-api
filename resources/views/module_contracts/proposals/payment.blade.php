@extends('layouts.master')
@section('content')
  <div class="create">
    <div class="formulario">
      <div>
        <h3>DETALLES DE PROPUESTA</h3>
        <div class="boxes" style="padding-top: 10px;">
          <div class="table-responsive tableother">
            <table class="table table-striped table-bordered text-center ">
              <thead>
                <tr class="bg-success">
                  <th>N° PROPUESTA</th>
                  @if($proposal[0]->contractId ==null)
                    <th>PRECONTRATO</th>
                  @else
                    <th>CONTRATO</th>
                  @endif                 
                  <th>DIRECCIÓN</th>
                  <th>CLIENTE</th>
                  <th>FECHA</th>
                  <th>SUB-TOTAL</th>
                  <th>IMPUESTO</th>
                  <th>TOTAL</th>
                  <th>CUOTAS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{$proposal[0]->propId}} </td>
                  @if($proposal[0]->contractId ==null)
                    <td>{{$proposal[0]->precontract->preId}} </td>
                    <td>{{$proposal[0]->precontract->siteAddress}} </td>
                  @else                    
                    <td>{{$proposal[0]->contract->contractNumber}} </td>
                    <td>{{$proposal[0]->contract->siteAddress}} </td>
                  @endif                    
                  <td>{{$proposal[0]->client->clientName}} </td>
                  <td>{{$proposal[0]->proposalDate}} </td>
                  <td>{{$proposal[0]->grossTotal }} </td>
                  <td>{{$proposal[0]->taxAmount }} </td>
                  <td>{{$proposal[0]->netTotal }} </td>
                  <td>{{$proposal[0]->pQuantity }} </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="input-label boxes2">
            <h4 style="font-size: 25px; font-weight: 700; text-align: center;">CUOTAS</h4>
            @can('BCEA')
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
              <form class="input-label" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;" action="{{Route('proposals.paymentsAdd')}}" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="proposalId" value="{{$proposal[0]->proposalId}}">
                <div class="inputother boxes2">  
                  <label for="paymentDate" >MOMENTO DEL PAGO</label>
                  <textarea id="paymentDate" name="paymentDate"  rows="3" required autocomplete="off"></textarea>
                </div>
                <div class="inputother boxes2">  
                  <label for="amount" >MONTO</label>
                  <input type="number" min='0.01' step="0.01" class="input-label" id="amount" name="amount" required autocomplete="off">
                </div>
                <br><br>
                <div style="width: 100%; display: flex; justify-content: center; align-items: flex-start;">  
                  <button type="submit" class="submit button-prevent-multiple-submits" style="background: green; margin-top: 0px;">
                    <span class="fa fa-plus" aria-hidden="true"></span>
                    Agregar Cuota
                  </button>
                </div> 
              </form>
            @endcan
          </div>
          <div class="table-responsive tableother">
            <table class="table table-striped table-bordered text-center ">
              <thead>
                <tr class="bg-info">
                  <th>N°</th>
                  <th>MOMENTO DEL PAGO</th>
                  <th>MONTO</th>
                  <th colspan="1">ACCIONES</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $acum = 0;
                  $total = 0; 
                ?>
                @foreach($payments as $payment)
                  <tr>
                    <td>{{ $acum = $acum +1 }}</td>
                    <td>{{$payment->paymentDate}}</td>
                    <td>{{$payment->amount}}</td>
                    <td>
                      @can('BCEB')   
                        <a href="{{route('proposals.paymentsRemove', [
                        'id' => $payment->paymentProposalId,
                        'proposalId' =>$proposal[0]->proposalId]) }}" class="return links-prevent-multiple-submits" style="padding: 5px 10px; background: #d60101;">
                                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a>
                      @endcan      
                    </td>
                  </tr>
                  @php  
                    $total = $total + $payment->amount; 
                    $total = number_format((float)$total, 2, '.', '');
                  @endphp 
                @endforeach
              </tbody>
            </table>
            <h3 class="text-success" align="center" >Monto Total: {{$total}}  </h3>
          </div>
          <div style="width: 100%; display: flex; justify-content: center; align-items: flex-start;">
            @if($btnReturn == 'mod_cont')
              @if($proposal[0]->contractId ==null)   
                <a href="{{route('proposals.index', ['id' => $proposal[0]->precontractId])}}" class="return">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                </a>
              @else
                <a href="{{route('invoices.index', ['id' => $proposal[0]->contractId])}}" class="return">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                </a>
              @endif
            @elseif($btnReturn == 'mod_adm')
              <a href="{{ URL::previous() }}" class="return">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

