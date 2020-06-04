@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b>SERVICIOS</b></h3></span>
<div class="text-center">

<div class="panel-body">

        <div class="row ">
          <div class="col-xs-12">

      <form class="form-inline" action="{{Route('services.store')}}" method="POST">
      {{csrf_field()}}

   {{-- <form-new-service pref-url=''></form-new-service> --}}

    <br>



 <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active "><a class="bg-info" href="#withPrice" aria-controls="withPrice" role="tab" data-toggle="tab">CON PRECIO</a></li>
    <li role="presentation"><a class="bg-info" href="#withoutPrice" aria-controls="withoutPrice" role="tab" data-toggle="tab">SIN PRECIO</a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="withPrice">
     <div class="row">
        <div class="col-xs-12 ">
            <br>

           <a href="{{route('services.create',['hasCost' => 'Y'])}}" class="btn btn-success"><span class="fa fa-plus" aria-hidden="true"></span> Crear Servicio</a>

             <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>

           <br><br>
            <table class="table table-striped table-bordered text-center bg-default">
            <thead>
                <tr>
                 <th>#</th>
                 <th>SERVICIO</th>
                 <th>PRECIO POR SQFT</th>
                 <th>PRECIO POR EA</th>
                 <th>{{__('actions')}}</th>
                </tr>
            </thead>
                <tbody>
            @php $acum=0; @endphp
                @foreach($servicesWithPrice as $service)
                <tr>
                   <td>{{++$acum}}</td>
                   <td>{{$service->serviceName}}</td>
                   <td>${{$service->cost1}}</td>
                   <td>${{$service->cost2}}</td>
                   <td><a href="{{route('services.edit', ['id' => $service->serviceId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span> {{__('edit')}}
                      </a>
                       <a href="{{route('services.show', ['id' => $service->serviceId])}}" class="btn btn-danger">
                        <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
     </div>
    </div>
   </div> <!--tab 1 final-->

    <div role="tabpanel" class="tab-pane" id="withoutPrice">
      <div class="row">
        <div class="col-xs-12 ">
                   <br>
            
           <a href="{{route('services.create',['hasCost' => 'N'])}}" class="btn btn-success"><span class="fa fa-plus" aria-hidden="true"></span> Crear Servicio</a>

             <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>

           <br><br>
            <table class="table table-striped table-bordered text-center bg-default">
            <thead>
                <tr>
                 <th>#</th>
                 <th>SERVICIO</th>
                 <th>{{__('actions')}}</th>
                </tr>
            </thead>
                <tbody>
            @php $acum=0; @endphp
                @foreach($servicesWithoutPrice as $service)
                <tr>
                   <td>{{++$acum}}</td>
                   <td>{{$service->serviceName}}</td>
                   <td><a href="{{route('services.edit', ['id' => $service->serviceId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span> {{__('edit')}}
                      </a>
                       <a href="{{route('services.show', ['id' => $service->serviceId])}}" class="btn btn-danger">
                        <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
     </div>
    </div>
  </div>  <!--tab 2 final-->

</div><!--tab container final-->


</div>
</div>
@endsection
