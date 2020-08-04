@extends('layouts.master')

@section('content')
<h3><b>PROPUESTAS POR OFICINA</b></h3>
<div class="text-center">
 <form class="form" action="{{Route('proposals.filtered')}}" method="POST">
        {{ csrf_field() }}
          <label for="date1">BUSQUEDA GENERAL:</label>
  <div class="col-xs-12">
          <div class="form-group col-lg-offset-3 col-lg-3">
              <select class="form-control" name="filterBy" id="filterBy">
                   <option value="invId" >N° Propuesta</option>
                   {{-- <option value="contractNumber" >Cod. de Precontrato </option> --}}
                   <option value="siteAddress" >Direccion </option>
                   <option value="clientCode" >Cod. de cliente</option>
                   <option value="clientName" >Nombre de cliente</option>
                   <option value="clientPhone" >Telefono de cliente</option>
              </select>
            </div>
          <div class="form-group col-lg-3">
              <input type="text" class="form-control" name="textToFilter" id="textToFilter" autocomplete="off" placeholder="Escriba un valor a buscar">
            </div>
   </div>            
  <div class="col-xs-12">
          <div class="form-group col-lg-offset-4 col-lg-2">
              <label for="date1">DESDE:</label> <input class="form-control flatpickr" id="date1" name="date1" value="{{ old('date1') }}" required> 
            </div>
            <div class="form-group col-lg-2">
              <label for="date2">HASTA:</label>
              <input class="form-control flatpickr" id="date2" name="date2" value="{{ old('date2') }}" required> 
            </div>
    </div>
    <div class="col-xs-12">
      <button type="submit" class="btn btn-primary">
        <span class="fa fa-search" aria-hidden="true"></span> Buscar
      </button>
    </div>
 </form>
.
    <div class="row">
        <div class="col-xs-12 ">

      <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead  class="bg-warning">
                <tr>
                 <th>#</th> 
                 <th>PROPOSAL ID</th> 
                 <th>DIRECCION</th>
                 <th>FECHA</th>
                 <th>DESCRIPCION DEL PROYECTO</th>
                 <th>SUB-TOTAL</th>
                 <th>IMPUESTO</th>
                 <th>TOTAL</th>
                 <th>CUOTAS</th>
                 <th>{{__('actions')}}</th> 
                 </th>
                </tr>
            </thead>
                <tbody>
         @php $acum = 0; @endphp
                @foreach($proposals as $proposal)
                <tr>
                   <td>{{ $acum = $acum +1 }}</td>
                   <td>
                    {{$proposal->propId}}
                  </td> 
                 @if($proposal->precontract == null)
                   <td>{{$proposal->contract->siteAddress}}</td>
                 @else
                   <td>{{$proposal->precontract->siteAddress}}</td>
                 @endif
                   <td>{{$proposal->proposalDate}}</td>
                   <td>{{$proposal->projectDescription->projectDescriptionName}}</td>
                   <td>{{$proposal->grossTotal}}</td>
                   <td>{{$proposal->taxAmount}}</td> 
                   <td>{{$proposal->netTotal}}</td> 
                   <td>{{$proposal->pQuantity}}</td> 
                   <td>
      <pre> 
         @php
              print_r(is_null($proposal->contract)); 
              print_r(is_null($proposal->precontract)); 
         @endphp
      </pre>
{{-- @if($proposal->precontract == null) --}}
      @if($proposal->contract)
{{-- @else
      @if($proposal->precontract)
@endif --}}
           @if($proposal->pQuantity > 0)
           @can('BCF')         
             <a href="{{route('precontracts.convert', ['id' => $proposal->proposalId])}}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Convertir en Factura">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
             </a>  
            @endcan       
           @endif

           @if($proposal->netTotal > 0)
            @can('BCE')           
           <a href="{{route('proposals.payments', ['btnReturn' => 'mod_adm','id' => $proposal->proposalId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
                        <span class="fa fa-dollar-sign" aria-hidden="true"></span> 
            </a>
            @endcan 
           @endif  

          @can('BCD') 
            <a href="{{route('proposalsDetails.index', ['btnReturn' => 'mod_adm','modelType' => 'pre_contract','id' => $proposal->proposalId])}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Renglones">
                        <span class="fa fa-book" aria-hidden="true"></span> 
              </a>
           @endcan
           @can('BCC') 
              <a href="{{route('reports.proposal', ['id' => $proposal->proposalId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
              </a>
           @endcan
           @can('BCC')    
              |
           <a href="{{route('proposals.edit', ['id' => $proposal->proposalId])}}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('edit')}}">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
          </a>  
          @endcan 
<!--             <a href="{{route('proposals.show', ['id' => $proposal->proposalId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}"><span class="fa fa-times-circle" aria-hidden="true"></span> 
                    </a> -->
 @else
        @can('BCC') 
           <a href="{{route('reports.proposal', ['id' => $proposal->proposalId])}}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
              </a>
                  @if($proposal->invoiceId != null)
                    (CONVERTIDA)
                  @endif
          @endcan
@endif
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
                {{-- {{$invoices->render()}} --}}
        </div>

        </div>
        </div>
    </div>



@endsection
