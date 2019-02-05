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
            <table class="table table-striped table-bordered text-center bg-success">
            <thead>
                <tr>
                 <th>ID</th>
                 <th>TIPO DE TRANSACCION</th>
                 <th>DESCRIPCION</th>
                 <th>FECHA</th>
                 <th>MONTO</th>
                 <th>BANCO</th>
                 <th>REFERENCIA</th>
                 <th>{{__('actions')}}</th>
                 </th>
                </tr>
            </thead>
                <tbody>
                @foreach($transactions as $transaction)
                <tr>
                   <td>{{$transaction->transactionId}}</td>
                   <td>{{$transaction->transactionType->transactionTypeName}}</td>
                   <td>{{$transaction->description}}</td>
                   <td>{{$transaction->transactionDate}}</td>
                   <td>{{$transaction->amount}}</td>
                   <td>{{$transaction->bank->bankName}}</td>
                   <td>{{$transaction->reference}}</td>

                   <td><!-- <a href="{{route('transactions.edit', ['id' => $transaction->transactionId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
                    </a>-->
                       <a href="{{route('transactions.show', ['sign'=>'+', 'id' => $transaction->transactionId])}}" class="btn btn-danger">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>

             <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
        </div>
    </div>

@endsection
