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
                    <td>{{$contract[0]->contractStatus }} </td>
                </tr>
        </tbody>
      </table>
  </div>

     <hr>
<div class="row ">
  <div class="col-xs-6 col-xs-offset-3">
    <h4 class="text-center"><b>{{__('STATUS')}}</b></h4>


      <form class="form" action="{{Route('contracts.updateStatus')}}" method="POST">
       {{csrf_field()}}
        {{method_field('PUT')}}

            <div class="form-group col-xs-6 col-xs-offset-3">
              <label for="contractStatus">{{__('choose_a_status')}}</label>
              <select class="form-control" name="contractStatus" id="contractStatus">
                @if ($contract[0]->contractStatus == __('vacancies'))
                   <option value="1" selected> {{__('vacancies')}} </option>
                @else
                  <option value="1" > {{__('vacancies')}} </option>
               @endif
                    @if ($contract[0]->contractStatus == __('initiates'))
                  <option value="2" selected> {{__('initiates')}} </option>
                @else
                <option value="2" > {{__('initiates')}} </option>
               @endif
                    @if ($contract[0]->contractStatus == __('finished'))
                  <option value="3" selected> {{__('finished')}} </option>
                @else
                <option value="3" > {{__('finished')}} </option>
               @endif
                    @if ($contract[0]->contractStatus == __('suspended'))
                    <option value="4" selected> {{__('suspended')}} </option>
                @else
                   <option value="4" > {{__('suspended')}} </option>
               @endif

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



       </div>
    </div>
  </div>


@endsection
