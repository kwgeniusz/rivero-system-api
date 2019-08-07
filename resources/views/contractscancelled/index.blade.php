@extends('layouts.master')

@section('content')
    <h3 class="text-danger"><b>CONTRATOS SUSPENDIDOS</b></h3>
    <br>
    <div class="row">
        <div class="col-xs-12 ">



         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead class="bg-danger">
                <tr>
                        <th>ID</th>
                        <th>{{__('contract_number')}}</th>
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


                   <td>
                     <a href="{{route('contracts.changeStatus', ['id' => $contract->contractId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{__('status')}}">
                     <span class="fa fa-sync" aria-hidden="true"></span>  
                    </a>
                    <a href="{{route('contracts.cancelledDetails', ['id' => $contract->contractId])}}" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="{{__('see')}}">
                        <span class="fa fa-search" aria-hidden="true"></span>  
                    </a>
                       <a href="{{route('contracts.cancelledShow', ['id' => $contract->contractId])}}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="{{__('delete')}}">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  
                        </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

<div class="text-center">
       <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
       </a>
</div>


    </div>
</div>

@endsection
