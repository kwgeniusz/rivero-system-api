@extends('layouts.master')

@section('content')


  <h3><b>PRE-CONTRATOS</b></h3>
<br>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">

    <li role="presentation" class="active"><a href="#Projects" aria-controls="Projects" role="tab" data-toggle="tab">PROYECTOS</a></li>
    <li role="presentation"><a href="#Services" aria-controls="Services" role="tab" data-toggle="tab">SERVICIOS</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="Projects">

   <div class="row">
        <div class="col-xs-12 ">
            <div class="text-center">
            <a href="{{ route('precontracts.create',['contractType' => 'P']) }}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                 Agregar Proyecto
            </a>
              <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
           </div>
           <br>
      </div>
    </div>

    <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
             <thead>
                <tr>
                 <th>N°</th>
                 <th>COD. {{__('client')}}</th>
                 <th>{{__('name')}}</th>   
                 <th>{{__('address')}}</th>
                 <th>{{__('options')}}</th>
                </tr>
            </thead>
                <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{$project->precontractId}} </td>
                    <td>{{$project->client->clientCode}}   </td>
                    <td>{{$project->client->clientName}}   </td>  
                    <td >{{$project->siteAddress}}   </td>
                    <td>
  
                     <a href="{{route('precontracts.convert', ['id' => $project->precontractId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Convertir en Contrato">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                    </a>
                     <a href="{{url("/preinvoices?id=$project->precontractId")}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Propuesta">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                    <a href="{{route('precontracts.edit', ['id' => $project->precontractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
                    <a href="{{route('precontracts.show', ['id' => $project->precontractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a>
                 </td>

                </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div> <!--tab 1 final-->

    <div role="tabpanel" class="tab-pane" id="Services">

     <div class="row">
        <div class="col-xs-12 ">
            <div class="text-center">
            <a href="{{ route('precontracts.create',['contractType' => 'S']) }}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                  Agregar Servicio
            </a>
              <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
           </div>
           <br>
      </div>
    </div>

   <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr>
                 <th>N°</th>
                 <th>COD. {{__('client')}}</th>
                 <th>{{__('name')}}</th>   
                 <th>{{__('address')}}</th>
                 <th>{{__('options')}}</th>
                </tr>
            </thead>
                <tbody>
                @foreach($services as $service)


                <tr>
                   <td>{{$service->precontractId}} </td>
                    <td>{{$service->client->clientCode}}   </td>
                    <td>{{$service->client->clientName}}   </td>  
                    <td >{{$service->siteAddress}}   </td>
                    <td>
                    <a href="{{route('precontracts.files', ['id' => $service->precontractId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Documentos" >
                     <span class="fa fa-file" aria-hidden="true"></span>
                    </a>
                   {{--  <a href="{{route('precontracts.payment', ['id' => $service->precontractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a> --}}
                    <a href="{{route('precontracts.convert', ['id' => $service->precontractId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Convertir en Contrato">
                     <span class="fa fa-sync" aria-hidden="true"></span>
                    </a>
                     <a href="{{url("/preinvoices?id=$service->precontractId")}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Propuesta">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                     <a href="{{route('precontracts.edit', ['id' => $service->precontractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
                    <a href="{{route('precontracts.show', ['id' => $service->precontractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>
                    </a>
                 </td>

                </tr>

                @endforeach
                </tbody>
            </table>
        </div>



    </div>

</div>



@endsection
