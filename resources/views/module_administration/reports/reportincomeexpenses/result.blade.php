@extends('layouts.master')

@section('content')

    <div class="embed-responsive embed-responsive-16by9">
         <iframe class="embed-responsive-item" src="{{ $outputPdfName }}"></iframe>
    </div>
    {{ $outputPdfName }}
@endsection
