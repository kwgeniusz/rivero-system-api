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
                 <th>PRECONTRATO</th>
                 <th>CLIENTE</th>
                 <th>DIRECCIÓN</th>
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
                    <td>{{$proposal[0]->precontract->preId}} </td>
                    <td>{{$proposal[0]->client->clientName}} </td>
                    <td>{{$proposal[0]->precontract->siteAddress}} </td>
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

    <div class="row ">
     <div class="col-xs-12">
     <div class="text-center">
      <form class="form-inline" action="{{Route('proposals.paymentsAdd')}}" method="POST">
      {{csrf_field()}}
         <div class="form-group">
            <label for="amount" >MONTO</label>
              <input style=" width:60%" type="number" min='0.01' step="0.01" class="form-control" id="amount" name="amount" required autocomplete="off">
         </div>
  {{--         <div class="form-group ">
                <label for="paymentDate">FECHA</label>
                <input style="width:50%" class="form-control flatpickr" id="paymentDate" name="paymentDate" required autocomplete="off">
              </div> --}}
           <input type="hidden" name="proposalId" value="{{$proposal[0]->proposalId}}">
           <button type="submit" class="btn btn-success">
                 <span class="fa fa-plus" aria-hidden="true"></span>
                 Agregar Cuota
            </button>
        </form>
   </div>
    </div>
    </div>


        <br>
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-info">
                 <th>N°</th>
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
                 <td>{{$payment->amount}}</td>
                 <td>
                  <a href="{{route('proposals.paymentsRemove', [
                  'id' => $payment->paymentProposalId,
                  'proposalId' =>$proposal[0]->proposalId]) }}" class="btn btn-danger btn-sm">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                  </a>
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
             <a href="{{route('proposals.index', ['id' => $proposal[0]->precontractId])}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>

       </div>
    </div>
  </div>


@endsection
