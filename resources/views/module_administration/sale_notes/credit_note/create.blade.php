@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-xs-12 ">
         <h3><b>NUEVA NOTA DE CREDITO</b></h3>
          <center><a href="{{URL::previous()}}" class="btn btn-warning">
                           <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                </a></center>
              <br>
            <credit-note invoice-id="" ></credit-note>
        </div>
      </div>

@endsection
