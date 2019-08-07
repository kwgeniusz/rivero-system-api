@extends('layouts.master')

@section('content')
<h3><b>{{__('client')}}</b></h3>
    <div class="row">
        <div class="col-xs-12 ">
            <div class="text-center">
            <a href="{{route('clients.create')}}" class="btn btn-success text-center" >
                <span class="fa fa-plus" aria-hidden="true"></span>
                   {{__('add')}}
            </a>

           <br><br>
         <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>ID</th> 
                 <th>CODIGO</th>
                 <th>{{__('name')}}</th>
                 <th>{{__('phone')}}</th>
                 <th>{{__('email')}}</th>
                 <th>CONTACTO</th>
                 <th>{{__('actions')}}</th>
                 </th>
                </tr>
            </thead>
                <tbody>
                @foreach($clients as $client)
                <tr>
                   <td>{{$client->cltId}}</td> 
                   <td>{{$client->clientCode}}</td>
                   <td>{{$client->clientName}}</td>
                   <td>{{$client->clientPhone}}</td>
                   <td>{{$client->clientEmail}}</td>
                   <td>{{$client->contactType->contactTypeName}}</td> 
                   <td><a href="{{route('clients.edit', ['id' => $client->clientId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span>  {{__('edit')}}
                    </a>
                       <a href="{{route('clients.show', ['id' => $client->clientId])}}" class="btn btn-danger">
                            <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>

             <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
        </div>
    </div>



@endsection
