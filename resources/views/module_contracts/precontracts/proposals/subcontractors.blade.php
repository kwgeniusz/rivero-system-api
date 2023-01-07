@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-xs-12">
             <h3><b>PROPUESTA > SUBCONTRATISTAS</b></h3>
             <div class="text-center">
                <a href=" {{URL::previous()}}" class="btn btn-warning">
                               <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                    </a>
             </div>
             <br>
             
              <proposal-subcontractors proposal-id="{{$proposal[0]->proposalId}}"></proposal-subcontractors>
        </div>
      </div>

@endsection
