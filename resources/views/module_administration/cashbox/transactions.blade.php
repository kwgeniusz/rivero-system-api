@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b> TRANSACCIONES EN CAJA</b></h3></span>
 
<div class="text-center">
<h4 class="text-success text-left">Saldo inicial año {{$year}}: <u>${{$initialBalance}}</u></h4>

 <form class="form" action="{{Route('cashbox.transactionsResults')}}" method="POST">
        {{ csrf_field() }}
          <label for="date1">BUSQUEDA GENERAL:</label>
  <div class="col-xs-12">
          <div class="form-group col-lg-offset-3 col-lg-3">
              <select class="form-control" name="filterBy" id="filterBy">
                   <option value="invId" >N° Factura</option>
                   <option value="contractNumber" >Cod. de contrato </option>
                   <option value="clientCode" >Cod. de cliente</option>
                   <option value="clientName" >Nombre de cliente</option>
                   <option value="clientPhone" >Telefono de cliente</option>
                   <option value="amount" >Monto</option>
                   <option value="responsable" >Responsable</option>
              </select>
            </div>
          <div class="form-group col-lg-3">
              <input type="text" class="form-control" name="textToFilter" id="textToFilter" autocomplete="off" placeholder="Escriba un valor a buscar">
            </div>
   </div>            
  <div class="col-xs-12">
          <div class="form-group col-lg-offset-4 col-lg-2">
              <label for="date1">DESDE:</label> <input class="form-control flatpickr" id="date1" name="date1" value="{{ old('date1') }}" required> 
            </div>
            <div class="form-group col-lg-2">
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

{{-- @if(!empty($transactions))       --}}
.
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead class="bg-info">
                <tr>
                 <th>#</th>
                 <th>FECHA</th>
                 <th>DESCRIPCION</th>
                 <th>MONTO</th>
                 <th>D/C</th>
                 <th>SALDO</th>
                 <th>RESPONSABLE</th>
                 {{-- <th>{{__('actions')}}</th> --}}
                 </th>
                </tr>
            </thead>
                <tbody>
                @php $acum = 0; @endphp
                @foreach($transactions as $transaction)
                <tr>
                   <td>{{ $acum = $acum +1 }}</td>
                   <td>{{$transaction->transactionDate}}</td>
                   <td><a href="">{{$transaction->description}} <br> {{$transaction->reason}}</a></td>
                   <td>{{$transaction->amount}}</td>
                   <td>{{$transaction->sign}}</td>
                   <td>{{$transaction->balance}}</td>
                   <td>{{$transaction->user->fullName}}</td>
                   {{-- <td> 
                       <a href="{{route('contracts.fileDownload', ['id' => $transaction->document->docId])}}" data-toggle="tooltip" data-placement="top" title="Descargar" class="btn btn-info">
                         <span class="fa fa-file" aria-hidden="true"></span> 
                      </a>
                       <a href="{{route('transactions.show', ['sign'=>'-', 'id' => $transaction->transactionId])}}" class="btn btn-danger" title="{{__('delete')}}">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                        </a>
                    <!-- <a href="{{route('transactions.edit', ['id' => $transaction->transactionId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
                    </a> -->
                       <modal-preview-document doc-url="{{$transaction->document->docUrl}}" ext="{{$transaction->document->mimeType}}"></modal-preview-document>
                   </td> --}}
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
{{-- @endif --}}

  
    </div>

@endsection
