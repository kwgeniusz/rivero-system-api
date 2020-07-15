@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
         <h3><b>NOTA DE DEBITO</b></h3>
          <center><a href="{{URL::previous()}}" class="btn btn-warning">
                           <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                </a></center>

            <invoice-details invoice-id="{{$invoice[0]->invoiceId}}"></invoice-details>
        </div>
      </div>

@endsection
