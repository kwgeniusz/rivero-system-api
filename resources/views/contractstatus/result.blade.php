@extends('layouts.master')

@section('content')
    <H2>{{__('search_result')}} </H2>

         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead class="bg-primary">
                <tr>
                        <th>ID</th>
                        <th> {{__('contract_number')}}</th>
                        <th>{{__('office')}}</th>
                        <th>{{__('date')}}</th>
                        <th>{{__('client')}}</th>
                        <th>{{__('status')}}</th>
                        <th>{{__('actions')}}</th>
                 </th>
                </tr>
            </thead>
                <tbody>
                @foreach($contracts as $contract)
                <tr>
                    <td>{{$contract->contractId}} </td>
                    <td>{{$contract->contractNumber}} </td>
                    <td>{{$contract->office->officeName}}   </td>
                    <td>{{$contract->contractDate}} </td>
                    <td>{{$contract->client->clientName}}   </td>
                    <td>{{$contract->contractStatus}}   </td>


                   <td><a href="{{route('contracts.resultStatusDetails', ['id' => $contract->contractId])}}" class="btn btn-default">
                        <span class="fa fa-search" aria-hidden="true"></span>  {{__('see')}}
                    </a>

                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <div class="col-xs-12 text-center">
               <a href="{{route('contracts.searchStatus')}}" class="btn btn-warning">
                <span class="fa fa-hand-point-left" aria-hidden="true"></span> {{__('return')}}
              </a>
             </div>

        </div>
    </div>
</div>

@endsection
