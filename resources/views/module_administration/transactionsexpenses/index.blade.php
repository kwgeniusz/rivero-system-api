@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b> TRANSACCIONES DE EGRESO</b></h3></span>
    <div class="row">
        <div class="col-xs-12 ">
            <div class="text-center">
            <a href="{{route('transactions.create',['sign'=>'-'])}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}} Egreso
            </a>

           <br><br>
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead class="bg-danger">
                <tr>
                 <th>ID</th>
                 <th>FECHA</th>
                 <th>REFERENCIA EN BANCO O BENEFICIARIO</th>
                 <th>METODO DE PAGO</th>
                 <th>DETALLES MP</th>
                 <th>MOTIVO</th>
                 <th>EXPENSES</th>
                 <th>MONTO</th>
                 <th>BANCO</th>
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
                   <td>{{$transaction->description}}</td>
                   <td>{{$transaction->paymentMethod->payMethodName}}</td>
                   <td>{{$transaction->payMethodDetails}}</td>
                   <td>{{$transaction->reason}}</td>
                   <td>{{$transaction->transactionType->transactionTypeName}}</td>
                   <td>{{$transaction->amount}}</td>
                   <td>{{$transaction->bank->bankName}}</td>
                   <td>{{$transaction->user->fullName}}</td>
                   <td><!-- <a href="{{route('transactions.edit', ['id' => $transaction->transactionId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
                    </a> -->
                       <a href="{{route('transactions.show', ['sign'=>'-', 'id' => $transaction->transactionId])}}" class="btn btn-danger">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>

             <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
        </div>
    </div>

@endsection
