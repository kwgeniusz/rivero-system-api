@extends('layouts.master')

@section('content')


<div class="panel panel-default col-xs-12">
    <div class="panel-body">

       <div class="row ">
        <div class="col-xs-12">
         <div class="text-center">

      <h4 class="text-info">BUSQUEDA GENERAL</h4>
      <form  action="{{Route('contracts.generalSearch')}}" method="GET">


<div class="col-xs-6 col-xs-offset-3">

  <select-country-office-contract></select-country-office-contract>
          <div class="input-group">
            <span class="input-group-addon"><label class="fa fa-sync"></label></span>
            <select placeholder="Estado Contrato" class="form-control" name="contractStatus" id="contractStatus">
                    <option value="" > Estado del Contrato </option>
                    <option value="1" > {{__('vacancies')}} </option>
                    <option value="2" > {{__('initiates')}} </option>
                    <option value="3" > {{__('finished')}} </option>
                    <option value="4" > {{__('suspended')}} </option>
              </select>
         </div>

            <label>Fecha de Contratacion</label>
          <div class="input-group">
              <span class="input-group-addon"><label class="fa fa-calendar-alt"></label></span>
           <input placeholder="Fecha de Contratacion" type="date" class="form-control" id="contractDate" name="contractDate">
         </div>
       <br>

           <button type="submit" class="btn btn-success">
                <span class="fa fa-search" aria-hidden="true"></span> Buscar
           </button>
         <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('return')}}
          </a>
    </div>
     </form>


        </div>
      </div>
    </div>

<hr>
<div class="text-center">

 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                   <th>ID</th>
                 <th>N° {{__('contract')}}</th>
                 <th>{{__('client')}}</th>
                 <th>{{__('phone')}}</th>
                 <th>{{__('address')}}</th>
                 <th>{{__('status')}}</th>
                 <th>{{__('date_of_contract')}}</th>
                 <th>{{__('actions')}}</th>
                </tr>
            </thead>
          <tbody>
                @foreach($contracts as $contract)
                <tr>
                    <td>{{$contract->contractId}} </td>
                    <td>{{$contract->contractNumber}} </td>
                    <td>{{$contract->client->clientName}}   </td>
                    <td>{{$contract->client->clientPhone}}   </td>
                    <td>{{$contract->siteAddress}}   </td>
                    <td>{{$contract->contractStatus}}   </td>
                    <td>{{$contract->contractDate}} </td>
                   <td>
                     <a href="{{route('contracts.generalSearchDetails', ['id' => $contract->contractId])}}" class="btn btn-default btn-sm">
                        <span class="fa fa-search" aria-hidden="true"></span>  {{__('see')}}
                    </a>
                 </td>

                </tr>

                @endforeach
                </tbody>
      </table>
     </div>
  {{$contracts->render()}}

    </div>

  </div>
</div>

@endsection
