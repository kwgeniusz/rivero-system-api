@extends('layouts.master')

@section('content')

<div class="col-xs-12 ">
<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h4><b>DETALLES DEL CONTRATO</b></h4></div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>N° {{__('contract')}}</th>
                 <th>{{__('country')}}</th>
                 <th>{{__('office')}}</th>
                 <th>{{__('date_of_contract')}}</th>
                 <th>{{__('client')}}</th>
                 <th>{{__('status')}}</th>
                 </th>
                </tr>
            </thead>
          <tbody>
                <tr>
                    <td>{{$contract[0]->contractNumber}} </td>
                    <td>{{$contract[0]->country->countryName}} </td>
                    <td>{{$contract[0]->office->officeName}} </td>
                    <td>{{$contract[0]->contractDate}} </td>
                    <td>{{$contract[0]->client->clientName}} </td>
                    <td>{{$contract[0]->contractStatus }} </td>
                </tr>
        </tbody>
      </table>
     </div>

     <hr>

     <div class="text-center"><h4><b>DOCUMENTOS DEL CONTRATO</b></h4></div>
     <br>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active "><a class="bg-info" href="#previous" aria-controls="previous" role="tab" data-toggle="tab">PREVIOS</a></li>
    <li role="presentation"><a class="bg-info" href="#processed" aria-controls="processed" role="tab" data-toggle="tab">PROCESADOS</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="previous">
        <br>
        <div class="row ">
                 <div class="col-xs-12">
                 <div class="text-center">
                  <form class="form-inline" action="{{Route('contracts.fileAgg')}}" method="POST"  enctype="multipart/form-data">
                     {{csrf_field()}}
                        <div class="form-group">
                          <input type="file" name="archive" id="archive">
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="contractId" value="{{$contract[0]->contractId}}">
                          <input type="hidden" name="typeDoc" value="previous"> 
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
    <br>
        <div class="row">
           <div class=" col-xs-8 col-xs-offset-2">
            <div class="table-responsive ">
            <table class="table table-striped table-bordered text-center ">
              
            <tr>
                <th>ARCHIVO</th>
                <th>TIPO</th>
                <th colspan="2">ACCION</th>
            </tr>
      @if($files)
      <?php $acum = 0;?>
       @foreach ($files as $file)
            <?php 
            $ext  = pathinfo($file, PATHINFO_EXTENSION);
            ?>
        <tr>
            <td><a href="{{ route('contracts.fileDownload', ['typeContract' => 'contracts','typeDoc' => 'previous','directoryName' => $directoryName,'file' => $file]) }}" >{{$file}}</a><br></td>
            <td> {{$ext}}</td>
            <td>  
              <modal-preview-document typecontract="contracts" directory-name="{{$directoryName}}" file="{{$file}}" ext="{{$ext}}"></modal-previuw-document>
            </td>
             <td> 
             <a href="{{ route('contracts.fileDelete', ['typeContract' => 'contracts','typeDoc' => 'previous','directoryName' => $directoryName,'file' => $file]) }}"  class="btn btn-danger btn-sm">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}} </a>
            </td>
        </tr>
         @endforeach
      @endif
        </table>
        </div>
      </div>
    </div>

   </div> <!--tab 1 final-->


    <div role="tabpanel" class="tab-pane" id="processed">
        <br>
            <div class="row ">
                 <div class="col-xs-12">
                 <div class="text-center">
                  <form class="form-inline" action="{{Route('contracts.fileAgg')}}" method="POST"  enctype="multipart/form-data">
                     {{csrf_field()}}
                        <div class="form-group">
                          <input type="file" name="archive" id="archive">
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="contractId" value="{{$contract[0]->contractId}}">
                          <input type="hidden" name="typeDoc" value="processed">   
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
         <br>
        <div class="row">
           <div class=" col-xs-8 col-xs-offset-2">
            <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <tr>
                <th>ARCHIVO</th>
                <th>TIPO</th>
                <th colspan="2">ACCION</th>
            </tr>
      @if($files2)
      <?php $acum = 0;?>
       @foreach ($files2 as $file)
            <?php 
            $ext  = pathinfo($file, PATHINFO_EXTENSION);
            ?>
        <tr>
            <td><a href="{{ route('contracts.fileDownload', ['typeContract' => 'contracts','typeDoc' => 'processed','directoryName' => $directoryName,'file' => $file]) }}" >{{$file}}</a><br></td>
            <td> {{$ext}}</td>
            <td>  
              <modal-preview-document typecontract="contracts" directory-name="{{$directoryName}}" file="{{$file}}" ext="{{$ext}}"></modal-previuw-document>
            </td>
             <td> 
             <a href="{{ route('contracts.fileDelete', ['typeContract' => 'contracts','typeDoc' => 'processed','directoryName' => $directoryName,'file' => $file]) }}"  class="btn btn-danger btn-sm">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}} </a>
            </td>
        </tr>
         @endforeach
      @endif
        </table>
        </div>
      </div>
    </div>
  </div>  <!--tab 2 final-->

</div><!--tab container final-->

    <div class="text-center">
        <a href="{{route('contracts.index')}}" class="btn btn-warning">
            <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
        </a>
    </div>
    <br>
@endsection

