@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
          <div class="text-center">
              <invoices-details invoice-id="{{$invoice[0]->invoiceId}}"></invoices-details>
           </div>   

        </div>
              <div class="text-center">
                <a href="{{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
              </div>
        </div>
    </div>



@endsection
