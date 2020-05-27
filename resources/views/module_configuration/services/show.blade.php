@extends('layouts.master')

@section('content')
<div class="col-xs-9 col-xs-offset-1">
<div class="panel panel-danger">
    <div class="panel-heading text-center"> <h3><b>¿Desea Eliminar Este servicio?</b></h3></div>
    <div class="panel-body">

   <form class="form form-prevent-multiple-submits" action="{{Route('services.destroy',['id' => $service[0]->serviceId])}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}

         <div class="form-group col-xs-8 col-xs-offset-2">
            <label for="serviceName">NOMBRE DEL SERVICIO</label>
            <input disabled="on" type="text" class="form-control" id="serviceName" name="serviceName"  value="{{$service[0]->serviceName}}"  >
          </div> 
      @if($service[0]->hasCost == 'Y')
         <div class="form-group col-xs-8 col-xs-offset-2 col-lg-5 col-lg-offset-2">
            <label for="cost1">PRECIO POR SQFT:</label>
            <input disabled="on" type="number" class="form-control" id="cost1" name="cost1"  value="{{$service[0]->cost1}}" >
          </div>

          <div class="form-group col-xs-8 col-xs-offset-2 col-lg-5 col-lg-offset-2">
                <label for="cost2">PRECIO POR EA:</label>
                <input disabled="on" type="number" class="form-control" id="cost2" name="cost2"  value="{{$service[0]->cost2}}" >
          </div>
     @endif
          <div class="col-xs-12 text-center">
              <button class="btn btn-primary button-prevent-multiple-submits"> <span class="fa fa-check" aria-hidden="true"></span> Confirmar</button>
               <a href="{{route('services.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                </a>
           </div>
</form>

  </div>
 </div>
</div>

@endsection
