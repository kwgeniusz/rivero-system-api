@extends('layouts.master')

@section('content')


<div class="col-xs-12 ">
<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h4 ><b>DETALLES DE PROPUESTA</b></h4></div>
 <div class="table-responsive">
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
                 </th>
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

     <hr>
     <h4 class="text-center"><b>CUOTAS</b></h4>
<br>
@can('BCEA')

  <div class="col-xs-offset-3 col-xs-5 ">
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

    <div class="row text-center">
      <form class="form-inline form-prevent-multiple-submits" action="{{Route('proposals.paymentsAdd')}}" method="POST">
      {{csrf_field()}}
          <input type="hidden" name="proposalId" value="{{$proposal[0]->proposalId}}">

        <div class="form-group col-xs-12">  
            <label for="paymentDate" >MOMENTO DEL PAGO</label>
          <textarea class="form-control" id="paymentDate" name="paymentDate"  rows="3" required autocomplete="off"></textarea>
         </div>
         
           <br><br>
          <div class="form-group col-xs-12">  
            <label for="amount" >MONTO</label>
              <input type="number" min='0.01' step="0.01" class="form-control" id="amount" name="amount" required autocomplete="off">
         </div>

         <br><br>
          <div class="form-group col-xs-12">  
           <button type="submit" class="btn btn-success button-prevent-multiple-submits">
                 <span class="fa fa-plus" aria-hidden="true"></span>
                 Agregar Cuota
            </button>
           </div> 

        </form>
    </div>

@endcan

        <br>
         <div class="table-responsive">
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
                  'proposalId' =>$proposal[0]->proposalId]) }}" class="btn btn-danger btn-sm links-prevent-multiple-submits">
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


           <div class="text-center">


             @if($btnReturn == 'mod_cont')
                  @if($proposal[0]->contractId ==null)   
                   <a href="{{route('proposals.index', ['id' => $proposal[0]->precontractId])}}" class="btn btn-warning">
                     <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                   </a>
                  @else
                  <a href="{{route('invoices.index', ['id' => $proposal[0]->contractId])}}" class="btn btn-warning">
                     <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                  </a>
                  @endif
             @elseif($btnReturn == 'mod_adm')
                  <a href="{{ URL::previous() }}" class="btn btn-warning">
                       <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                  </a>
             @endif

            </div>

       </div>
    </div>
  </div>


@endsection
