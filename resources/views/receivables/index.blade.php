@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b>CUENTAS POR COBRAR</b></h3></span>
<div class="text-center">

<div class="panel-body">

        <div class="row ">
          <div class="col-xs-12">
      <form class="form-inline" action="{{Route('receivables.index')}}" method="POST">
      {{csrf_field()}}

        <div class="form-group">
            <label for="countryId">{{__('country')}}</label>
            <select class="form-control" name="countryId" id="countryId">
                @foreach($countrys as $country)
                      <option value="{{$country->countryId}}" > {{$country->countryName}} </option>
                @endforeach
            </select>
          </div>
           <button type="submit" class="btn btn-primary">
                <span class="fa fa-search" aria-hidden="true"></span> {{__('search')}}
            </button>
        </form>
              </div>
            </div>

    <hr>
@if($receivables)
    <div class="row">
        <div class="col-xs-12 ">
            <table class="table table-striped table-bordered text-center">
            <thead class="bg-success">
                <tr>
                 <th>COD. CLIENTE</th>
                 <th>NOMBRE</th>
                 <th>DIRECCIÓN</th>
                 <th>TELEFONO</th>
                 <th>CUOTAS</th>
                 <th>DEUDA TOTAL</th>
                 <th>{{__('options')}}</th>
                </tr>
            </thead>
                <tbody>
            @foreach($receivables as $receivable)
                <tr>
                     <td>{{$receivable->client[0]->clientCode}}</td>
                     <td>{{$receivable->client[0]->clientName}}</td>
                     <td>{{$receivable->client[0]->clientAddress}}</td>
                     <td>{{$receivable->client[0]->clientPhone}}</td>
                      <td>{{$receivable->cuotas}}</td>
                       <td>{{$receivable->total}}</td>
                     <td><a href="{{route('receivables.details', ['clientId' => $receivable->clientId])}}" class="btn btn-info">
                        <span class="fa fa-file" aria-hidden="true"></span> Detalles
                    </a>
                   </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endif
   <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
 </div>
</div>
@endsection
