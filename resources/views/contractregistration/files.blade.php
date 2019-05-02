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
            <div class="row ">
                    <div class="col-xs-12">
                    <div class="text-center">
                     <form class="form-inline" action="{{Route('contracts.fileAgg')}}" method="POST"  enctype="multipart/form-data">
                     {{csrf_field()}}
                        <div class="form-group">
                          <input type="file" name="archive" id="archive">
                        </div
                        <div class="form-group">
                          <input type="hidden" name="contractId" value="{{$contract[0]->contractId}}">
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
                <th>ACCION</th>
            </tr>
@if($files)
       @foreach ($files as $file)
   <?php $ext  = pathinfo($file, PATHINFO_EXTENSION);?>
            <tr>
             <td><a href="{{ route('uploads', ['directoryName' => $directoryName,'file' => $file]) }}" >{{$file}}</a> <br>
             </td>

             <td> {{$ext}}</td>

             <td> <a @click="$refs.modalChangeStatus.open()"  class="btn btn-primary btn-sm">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  Ver
                  </a>
             <a href="{{ route('files.delete', ['directoryName' => $directoryName,'file' => $file]) }}"  class="btn btn-danger btn-sm">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                 </a>
             </td>
{{storage_path("app/public/docs/$directoryName/$file")}}
{{asset("storage/docs/D1119PC-0000047/$file")}}
   <!--Windows Modal previuws-->
        <sweet-modal modal-theme="dark" overlay-theme="dark" ref="modalChangeStatus">
            <b> Previzualicion Del Documento.</b>
           <br /><br />
           <iframe src="https://view.officeapps.live.com/op/embed.aspx?src=" style="width:550px; height:400px;" frameborder="0">
           </iframe>
        </sweet-modal>

            </tr>
         @endforeach
@endif
        </table>
        </div>
    </div>
    </div>

    <div class="text-center">
        <a href="{{route('contracts.index')}}" class="btn btn-warning">
            <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
        </a>
    </div>
    <br>



@endsection

