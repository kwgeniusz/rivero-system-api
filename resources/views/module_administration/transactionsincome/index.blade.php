@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b> TRANSACCIONES DE INGRESO</b></h3></span>
    <div class="row">
        <div class="col-xs-12 ">
            <div class="text-center">
            <a href="{{route('transactions.create',['sign'=>'+'])}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}} Ingreso
            </a>

           <br><br>
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead class="bg-success">
                <tr>
                 <th>ID</th>
                 <th>FECHA</th>
                 <th>DESCRIPCION</th>
                 {{-- <th>DETALLES MP</th> --}}
                 <th>N° FACTURA</th>
                 <th>MOTIVO</th>
                 <th>METODO DE PAGO</th>
                 <th>BANCO</th>
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
                   <td>{{$transaction->description}}</td>
                   {{-- <td>{{$transaction->payMethodDetails}}</td> --}}
                   <td>@if($transaction->invoice != null)
                    {{$transaction->invoice->invId}}
                     @endif
                  </td>
                   <td>{{$transaction->reason}}</td>
                   <td>{{$transaction->paymentMethod->payMethodName}}</td>
                   <td>{{$transaction->bank->bankName}}</td>
                   <td>{{$transaction->amount}}</td>
                   <td>{{$transaction->user->fullName}}</td>

                   <td>
       <!--              <a href="{{route('transactions.edit', ['id' => $transaction->transactionId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
                    </a> -->
          @if($transaction->invoice == null)  
              <a href="{{route('transactions.show', ['sign'=>'+', 'id' => $transaction->transactionId])}}" class="btn btn-danger">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a> 
          @endif   
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
