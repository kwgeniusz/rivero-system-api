@extends('layouts.master')

@section('content')

<div class="col-xs-12 ">
<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h4><b>DETALLES DEL PRE-CONTRATO</b></h4></div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>N° PRE-CONTRATO</th>
                 <th>{{__('country')}}</th>
                 <th>{{__('office')}}</th>
                 <th>{{__('client')}}</th>
                   <th>{{__('address')}}</th>
                 </th>
                </tr>
            </thead>
          <tbody>
                <tr>
                    <td>{{$precontract[0]->precontractId}} </td>
                    <td>{{$precontract[0]->country->countryName}} </td>
                    <td>{{$precontract[0]->office->officeName}} </td>
                    <td>{{$precontract[0]->client->clientName}} </td>
                    <td>{{$precontract[0]->siteAddress}} </td>
                </tr>
        </tbody>
      </table>
     </div>

     <hr>

     <div class="text-center"><h4><b>DOCUMENTOS DEL CONTRATO</b></h4></div>
     <br>
            <div class="row ">
                 <div class="col-xs-12">
                 <div class="text-center">
                  <form class="form-inline" action="{{Route('precontracts.fileAgg')}}" method="POST"  enctype="multipart/form-data">
                     {{csrf_field()}}
                        <div class="form-group">
                          <input type="file" name="archive" id="archive">
                        </div
                        <div class="form-group">
                          <input type="hidden" name="precontractId" value="{{$precontract[0]->precontractId}}">
                          <button type="submit" class="btn btn-success">
                                <span class="fa fa-plus" aria-hidden="true"></span>
                                Subir Archivo
                           </button>
                        </div>
                    </form>
                  </div>
                </div>
            </div>
      <hr>
    <div class="row">
       <div class=" col-xs-8 col-xs-offset-2">
        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <tr>
                <th>ARCHIVO</th>
                <th>TIPO</th>
                <th colspan="2">ACCION</th>
            </tr>
      @if($files)
      <?php $acum = 0;?>
       @foreach ($files as $file)
            <?php $ext  = pathinfo($file, PATHINFO_EXTENSION); ?>
        <tr>
            <td><a href="{{ route('precontracts.fileDownload', ['typeContract' => 'precontracts','directoryName' => $directoryName,'file' => $file]) }}" >
                 {{$file}}</a><br></td>
            <td> {{$ext}}</td>
            <td>  
               <modal-preview-document type-contract="precontracts" directory-name="{{$directoryName}}" file="{{$file}}" ext="{{$ext}}"></modal-previuw-document>
            </td>
             <td> 
             <a href="{{ route('precontracts.fileDelete', ['typeContract'=> 'precontracts','directoryName' => $directoryName,'file' => $file]) }}"  class="btn btn-danger btn-sm">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}} </a>
            </td>
        </tr>
         @endforeach
      @endif
        </table>
        </div>
    </div>
    </div>

    <div class="text-center">
        <a href="{{route('precontracts.index')}}" class="btn btn-warning">
            <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
        </a>
    </div>
    <br>



@endsection

