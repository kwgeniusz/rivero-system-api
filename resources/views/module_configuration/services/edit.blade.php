@extends('layouts.master')

@section('content')
<div class="col-xs-9 col-xs-offset-1">
<div class="panel panel-success">
    <div class="panel-heading text-center"> <h3><b>EDITAR SERVICIO</b></h3></div>
    <div class="panel-body">

        @if ($errors->any())
          <div class="alert alert-danger">
              <h4>Errores:</h4>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
 <form class="form form-prevent-multiple-submits" action="{{Route('services.update',['id' => $service[0]->serviceId])}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

        <input type="hidden" name="hasCost" value="{{$service[0]->hasCost}}">
         <div class="form-group col-xs-8 col-xs-offset-2">
            <label for="serviceName">NOMBRE DEL SERVICIO</label>
            <input type="text" class="form-control" id="serviceName" name="serviceName"  value="{{$service[0]->serviceName}}"  >
          </div> 
      @if($service[0]->hasCost == 'Y')
         <div class="form-group col-xs-8 col-xs-offset-2 col-lg-5 col-lg-offset-2">
            <label for="cost1">PRECIO POR SQFT:</label>
            <input type="number" class="form-control" id="cost1" name="cost1"  value="{{$service[0]->cost1}}" >
          </div>

          <div class="form-group col-xs-8 col-xs-offset-2 col-lg-5 col-lg-offset-2">
                <label for="cost2">PRECIO POR EA:</label>
                <input type="number" class="form-control" id="cost2" name="cost2"  value="{{$service[0]->cost2}}" >
          </div>
     @endif
          <div class="col-xs-12 text-center">
              <button class="btn btn-primary button-prevent-multiple-submits"> <span class="fa fa-check" aria-hidden="true"></span> Guardar</button>
               <a href="{{route('services.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
                </a>
           </div>
</form>

  </div>
 </div>
</div>

@endsection
