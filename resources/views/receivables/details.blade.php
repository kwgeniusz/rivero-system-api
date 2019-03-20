@extends('layouts.master')

@section('content')


<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h4 class="text-info">DATOS DEL CLIENTE</h4></div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>NOMBRE</th>
                 <th>DESCRIPCION</th>
                 <th>DIRECCION</th>
                 <th>TELEFONO</th>
                 <th>CUOTAS</th>
                 <th>DEUDA TOTAL</th>
                 </th>
                </tr>
            </thead>
          <tbody>
                <tr>
                     <td>{{$client[0]->client[0]->clientName}}</td>
                     <td>{{$client[0]->client[0]->clientDescription}}</td>
                     <td>{{$client[0]->client[0]->clientAddress}}</td>
                     <td>{{$client[0]->client[0]->clientPhone}}</td>
                     <td>{{$client[0]->cuotas}}</td>
                     <td>{{$client[0]->total}}</td>
                </tr>
        </tbody>
      </table>
  </div>

     <hr>

<div class="row ">
  <div class="col-xs-12">
    <h4 class="text-info text-center">DETALLES - CUENTAS POR COBRAR</h4>
         <!-- INICIO DE LA TABLA COLLAPSE COMPONENT -->
   @foreach($receivablesContracts as $index => $contract)
<?php
$acum     = 0;
$totalDue = 0;
?>
     <div class="panel-group col-xs-6" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-primary">
         <div class="panel-heading" role="tab" id="headingOne">
           <h4 class="panel-title">
             <div role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$index}}" aria-expanded="true" aria-controls="{{$index}}">
              @foreach($contract as $share) <?php $totalDue += $share->amountDue?> @endforeach
              CONTRATO N° "{{$index}}" - MONTO A COBRAR: {{$totalDue}}
            </div>
           </h4>
         </div>
          <div id="{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
           <div class="panel-body">
           <h4 class="text-info text-center">CUOTAS</h4>
              <!-- INICIO DE LA TABLA CUOTAS -->
               <div class="table-responsive">
                   <table class="table table-striped table-bordered text-center ">
                   <thead>
                       <tr class="bg-info">
                        <th>N°</th>
                        <th>MONTO</th>
                        <th>ACCIONES</th>
                       </tr>
                   </thead>
                  <tbody>
                   @foreach($contract as $share)
                       <tr>
                        <td>{{ $acum = $acum +1 }}</td>
                        <td>{{$share->amountDue}}</td>
                        <td>
                           <form-modal-charge r-id="{{$share->receivableId}}" country-id="{{$share->countryId}}"></form-modal-charge>
                       </td>
                       </tr>
                    @endforeach
                 </tbody>
                </table>
                <!-- FIN TABLA CUOTAS -->
            </div>

          </div>
         </div>
        </div>
    </div>
   @endforeach
   <!-- FIN COLLAPSED -->
    </div>
  </div>
            <div class="text-center">
             <a href="{{route('receivables.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
           </div>
       </div>
    </div>



@endsection
