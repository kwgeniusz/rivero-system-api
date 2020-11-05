@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
         <h3><b>NUEVA NOTA DE DEBITO</b></h3>
          <center><a href="{{route('invoiceSaleNotes.getAll', ['id' => $invoiceId])}}" class="btn btn-warning">
                           <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                </a></center>
             <br>
            <debit-note invoice-id="{{$invoiceId}}" ></debit-note>
        </div>
      </div>

@endsection
