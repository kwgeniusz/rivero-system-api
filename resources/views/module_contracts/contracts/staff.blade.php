@extends('layouts.master')

@section('content')

<div class="col-xs-12 ">
<div class="panel panel-default col-xs-12">
    <div class="panel-body">

<div class="text-center"><h4><b>{{__('details_contract')}}</b></h4></div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>N° {{__('contract')}}</th>
                 <th>{{__('country')}}</th>
                 <th>{{__('office')}}</th>
                 <th>DIRECCION       </th>
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
                    <td>{{$contract[0]->siteAddress}} </td>
                    <td>{{$contract[0]->contractDate}} </td>
                    <td>{{$contract[0]->client->clientName}} </td>
                    <td>{{$contract[0]->contractStatusR[0]->contStatusName }} </td>
                </tr>
        </tbody>
      </table>
     </div>

     <hr>
    <h4 class="text-center"><b>PERSONAL ASIGNADO</b></h4>
    <br>


@if($staffs)
    <div class="row ">
     <div class="col-xs-12">
     <div class="text-center">
      <form class="form-inline" action="{{Route('contracts.staffAdd')}}" method="POST">
      {{csrf_field()}}
         <div class="form-group">
            <label for="staff">PERSONAL DISPONIBLE</label>
            <select class="form-control" name="staffId" id="staff">
                @foreach($staffs as $staff)
                      <option value="{{$staff->staffId}}" >{{$staff->fullName}} </option>
                @endforeach
            </select>
          </div>
           <input type="hidden" name="contractId" value="{{$contract[0]->contractId}}">
           <button type="submit" class="btn btn-success">
                 <span class="fa fa-plus" aria-hidden="true"></span>
                 {{__('agg_staff')}}
            </button>
        </form>
   </div>
      </div>
    </div>
@endif

        <br>
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-warning">
                 <th>ID</th>
                 <th>NOMBRES Y APELLIDOS</th>
                 <th>POSICION</th>
                 <th>OFICINA</th>
                 <th>ACCIONES</th>
                </tr>
            </thead>
          <tbody>
            @foreach($contract[0]->staff as $staff)
                <tr>
                 <td>{{$staff->staffId}}</td>
                 <td>{{$staff->fullName}}</td>
                 <td>{{$staff->position->positionName}}</td>
                 <td>{{$staff->office->officeName}}</td>
                 <td>
                  <a href="{{route('contracts.staffRemove', [
                  'contractId' => $contract[0]->contractId,
                  'staffId'    => $staff->staffId]) }}" class="btn btn-danger btn-sm">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                  </a></td>
                </tr>
              @endforeach
        </tbody>
      </table>
     </div>


           <div class="text-center">
              <a href="{{route('contracts.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
            </div>

       </div>
    </div>
  </div>


@endsection
