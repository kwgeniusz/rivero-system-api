@extends('layouts.master')

@section('content')


  <h3><b>{{__('contracts')}}</b></h3>
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
            <a href="{{ route('contracts.create',['contractType' => 'P']) }}" class="btn btn-success text-center" >
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
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>ID</th>
                 <th>N° {{__('contract')}}</th>
                 <th>COD. {{__('client')}}</th>
                 <th>{{__('address')}}</th>
                 <th>{{__('status')}}</th>
                 <th>{{__('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{$project->conId}} </td>
                    <td>{{$project->contractNumber}} </td>
                    <td>{{$project->client->clientCode}}   </td>
                    <td >{{$project->siteAddress}}   </td>
                    <td>{{$project->contractStatus}}   </td>
                    <td>
                     <a href="{{route('contracts.changeStatus', ['id' => $project->contractId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('status')}}">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                    </a>
                    <a href="{{route('contracts.staff', ['id' => $project->contractId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('staff')}}">
                     <span class="fa fa-users" aria-hidden="true"></span> 
                    </a>
                    <a href="{{route('contracts.files', ['id' => $project->contractId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Documentos">
                     <span class="fa fa-file" aria-hidden="true"></span> 
                    </a>
                     <a href="{{route('contracts.payment', ['id' => $project->contractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                   <a href="{{route('contracts.details', ['id' => $project->contractId])}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('see')}}">
                        <span class="fa fa-search" aria-hidden="true"></span> 
                    </a>
                    <a href="{{route('contracts.edit', ['id' => $project->contractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
                    <a href="{{route('contracts.show', ['id' => $project->contractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
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
            <a href="{{ route('contracts.create',['contractType' => 'S']) }}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                  Agregar Servicio
            </a>
              <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('return')}}
              </a>
           </div>
           <br>
      </div>
    </div>

   <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
           <thead>
                <tr>
                 <th>ID</th>
                 <th>N° {{__('contract')}}</th>
                 <th>COD. {{__('client')}}</th>
                 <th>{{__('address')}}</th>
                 <th>{{__('status')}}</th>
                 <th>{{__('options')}}</th>
                </tr>
            </thead>
                <tbody>
                @foreach($services as $service)
                  <tr>
                     <td>{{$service->conId}} </td>
                    <td>{{$service->contractNumber}} </td>
                    <td>{{$service->client->clientCode}}   </td>
                    <td >{{$service->siteAddress}}   </td>
                    <td>{{$service->contractStatus}}   </td>
                    <td>
                     <a href="{{route('contracts.changeStatus', ['id' => $service->contractId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('status')}}">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                    </a>
                    <a href="{{route('contracts.staff', ['id' => $service->contractId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('staff')}}">
                     <span class="fa fa-users" aria-hidden="true"></span> 
                    </a>
                    <a href="{{route('contracts.files', ['id' => $service->contractId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Documentos">
                     <span class="fa fa-file" aria-hidden="true"></span> 
                    </a>
                     <a href="{{route('contracts.payment', ['id' => $service->contractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                   <a href="{{route('contracts.details', ['id' => $service->contractId])}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('see')}}">
                        <span class="fa fa-search" aria-hidden="true"></span> 
                   </a>
                    <a href="{{route('contracts.edit', ['id' => $service->contractId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
                    <a href="{{route('contracts.show', ['id' => $service->contractId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a>
                 </td>

                </tr>

                @endforeach
                </tbody>
            </table>
        </div>



    </div> <!-- tab 2-->

</div>



@endsection
