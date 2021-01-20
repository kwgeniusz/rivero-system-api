@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b> TRANSACCIONES DE INGRESO</b></h3></span>

  <div class="col-xs-3 text-left">
      <h5 class="text-success">Ingresos de facturas: ${{$totalTransaction}}</h5>
      <h5 class="text-success ">Fee: ${{$totalFee}}</h5>
      <h5 class="text-success ">Manuales: ${{$totalManual}}</h5>
      <h5 class="text-success ">Total: ${{$totalManual + $totalFee + $totalTransaction}}</h5>
  </div>

  <div class="col-xs-6 text-center">
   <form class="form" action="{{Route('transactions.filtered',['sign'=>'+'])}}" method="POST">
        {{ csrf_field() }}

  <h4 class="text-center">BUSQUEDA GENERAL:</h4>
          <div class="form-group col-lg-6">
              <select class="form-control" name="filterBy" id="filterBy">
                   <option value="invId" >N° Factura</option>
                   <option value="contractNumber" >Cod. de Contrato </option>
                   <option value="clientCode" >Cod. de Cliente</option>
                   <option value="clientName" >Nombre de Cliente</option>
                   <option value="clientPhone" >Telefono de Cliente</option>
                   <option value="amount" >Monto</option>
                   <option value="transactionType" >Tipo de Transaccion</option>
                   <option value="paymentMethod" >Metodo de Pago</option>
                   <option value="description" >Descripcion</option>
                   <option value="reason" >Motivo</option>
                   <option value="responsable" >Responsable</option>
              </select>
            </div>
            <div class="form-group col-lg-6">
              <input type="text" class="form-control" name="textToFilter" id="textToFilter" autocomplete="off" placeholder="Escriba un valor a buscar">
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

    <input type="hidden" name="sign" value="+">

    <div class="col-xs-12">
      <button type="submit" class="btn btn-primary">
        <span class="fa fa-search" aria-hidden="true"></span> Buscar
      </button>
    </div>
 </form>
</div>

  <div class="col-xs-3 text-right">
   <b> Opciones: </b> 
        <a href="{{route('transactions.create',['sign'=>'+'])}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}} Ingreso
        </a><br><br>
  </div>
         
    <div class="row">
        <div class="col-xs-12">


           <br><br>
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead class="bg-success">
                <tr>
                 <th>#</th>
                 <th>FECHA</th>
                 <th>DESCRIPCION</th>
                 {{-- <th>DETALLES MP</th> --}}
                 <th>FACTURA</th>
                 <th>MOTIVO</th>
                 <th>METODO DE PAGO</th>
                 <th>DESTINO</th>
                 <th>MONTO</th>
                 <th>RESPONSABLE</th>
                 <th>{{__('actions')}}</th>
                 </th>
                </tr>
            </thead>
                <tbody>   
         @php $acum = 0; @endphp
                @foreach($transactions as $transaction)
                <tr>
                   <td>{{ $acum = $acum +1 }}</td>
                   <td>{{$transaction->transactionDate}}</td>
                   <td>{{$transaction->description}} <br>
                    @if($transaction->invoice != null)
                    {{$transaction->invoice->contract->siteAddress}}
                    @endif
                  </td>
                   {{-- <td>{{$transaction->payMethodDetails}}</td> --}}
                   <td>@if($transaction->transactionable != null)
                    {{$transaction->transactionable->invId}}
                     @endif
                  </td>
                   <td>{{$transaction->reason}}</td>
                   <td>{{$transaction->paymentMethod->payMethodName}}</td>
                  @if($transaction->cashboxId == null) 
                   <td>{{$transaction->account->bank->bankName}}<br> {{$transaction->account->accountCodeId}}</td>
                  @else
                   <td>CASHBOX</td>
                  @endif 
                   <td>{{$transaction->amount}}</td>
                   <td>{{$transaction->user->fullName}}</td>

                   <td>
          @if($transaction->transactionable_id == null)  
       <!--<a href="{{route('transactions.edit', ['id' => $transaction->transactionId])}}" class="btn btn-primary"><span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
                    </a> -->
              <a href="{{route('transactions.show', ['sign'=>'+', 'id' => $transaction->transactionId])}}" class="btn btn-danger" title="{{__('delete')}}">
                          <span class="fa fa-times-circle" aria-hidden="true"></span> 
                        </a> 
          @endif  
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>

          {{--    <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
 --}}
        </div>
    </div>
  

@endsection
