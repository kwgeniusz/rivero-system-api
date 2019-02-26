@extends('layouts.master')

@section('content')

<div class="col-xs-12 ">
<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h3 class="text-info">DETALLES DEL PRE-CONTRATO</h3></div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>N°</th>
                 <th>{{__('country')}}</th>
                 <th>{{__('office')}}</th>
                 <th>{{__('client')}}</th>
                 <th>{{__('address')}}</th>
                 <th>COSTO</th>
                 </th>
                </tr>
            </thead>
          <tbody>
                <tr>
                    <td>{{$precontract[0]->precontractId}} </td>
                    <td>{{$precontract[0]->country->countryName}} </td>
                    <td>{{$precontract[0]->office->officeName}} </td>
                    <td>{{$precontract[0]->client->clientName}} </td>
                    <td>{{$precontract[0]->siteAddress }} </td>
                    <td>{{$precontract[0]->precontractCost }} </td>
                </tr>
        </tbody>
      </table>
     </div>

     <hr>
     <h3 class="text-info"><b> PAGOS</b></h3>

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
      <form class="form-inline" action="{{Route('precontracts.paymentAgg')}}" method="POST">
      {{csrf_field()}}
         <div class="form-group">
            <label for="amount" >MONTO</label>
              <input style=" width:60%" type="number" step="0.01" class="form-control" id="amount" name="amount" required>
         </div>
          <div class="form-group ">
                <label for="paymentDate">FECHA</label>
                <input style="width:50%" class="form-control flatpickr" id="paymentDate" name="paymentDate" required>
              </div>
           <input type="hidden" name="precontractId" value="{{$precontract[0]->precontractId}}">
           <button type="submit" class="btn btn-success">
                 <span class="fa fa-plus" aria-hidden="true"></span>
                 Agregar Pago
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
                 <th>ID</th>
                 <th>MONTO</th>
                 <th>FECHA</th>
                 <th>ACCIONES</th>
                </tr>
            </thead>
          <tbody>
        <?php $acum = 0?>
            @foreach($payments as $payment)

                <tr>
                 <td>{{ $acum = $acum +1 }}</td>
                 <td>{{$payment->amount}}</td>
                 <td>{{$payment->paymentDate}}</td>
                 <td>
                  <a href="{{route('precontracts.paymentRemove', [
                  'id' => $payment->paymentPrecontractId,
                  'amount' => $payment->amount,
                  'precontractId' =>$precontract[0]->precontractId]) }}" class="btn btn-danger btn-sm">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                  </a></td>
                </tr>
              @endforeach
        </tbody>
      </table>
     </div>


           <div class="text-center">
              <a href="{{route('precontracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>

       </div>
    </div>
  </div>


@endsection
