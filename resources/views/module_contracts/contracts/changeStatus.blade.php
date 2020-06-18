@extends('layouts.master')

@section('content')

<div class="panel panel-default col-lg-12">
    <div class="panel-body text-center">

<div class="text-center">
  <h4><b>{{__('details_contract')}}</b></h4>
</div>
 <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>N° {{__('contract')}}</th>
                 <th>{{__('country')}}</th>
                 <th>{{__('office')}}</th>
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
                    <td>{{$contract[0]->contractDate}} </td>
                    <td>{{$contract[0]->client->clientName}} </td>
                    <td>{{$contract[0]->contractStatusR[0]->contStatusName }} </td>
                </tr>
        </tbody>
      </table>
  </div>

     <hr>

    <h4><b>{{__('STATUS')}}</b></h4>
      <form class="form" action="{{Route('contracts.updateStatus')}}" method="POST">
       {{csrf_field()}}
        {{method_field('PUT')}}

            <div class="form-group col-lg-6 col-lg-offset-3">
              <label for="contractStatus">{{__('choose_a_status')}}</label>

              <select class="form-control" name="contractStatus" id="contractStatus">
                @foreach($contractStatus as $status)
                 @if ($contract[0]->contractStatus == $status->contStatusCode)
                      <option selected value="{{$status->contStatusCode}}" >{{$status->contStatusName}}</option>
                 @else
                      <option value="{{$status->contStatusCode}}" >{{$status->contStatusName}}</option>
                 @endif
                @endforeach
              </select>
            </div>
           <input type="hidden" name="contractId" value="{{$contract[0]->contractId}}">

       <div class="row"></div>
       <div class="text-center">
           <button type="submit" class="btn btn-success">
                 <span class="fa fa-sync" aria-hidden="true"></span>
                 {{__('change_status')}}
            </button>

              <a href="{{URL::previous()}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>

     </form>

       </div>
    </div>

@endsection
