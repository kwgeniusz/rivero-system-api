@extends('layouts.master')

@section('content')
<center>
       <a href="{{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
       </a>
</center>
       <br><br>
    <div class="embed-responsive embed-responsive-16by9">
         <iframe class="embed-responsive-item" src="{{ $outputPdfName }}"></iframe>
    </div>
    {{ $outputPdfName }}
@endsection
