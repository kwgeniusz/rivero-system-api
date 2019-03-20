@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b>{{__('type_of_service')}}</b></h3></span>
<div class="text-center">

<div class="panel-body">

        <div class="row ">
          <div class="col-xs-12">

      <form class="form-inline" action="{{Route('services.store')}}" method="POST">
      {{csrf_field()}}


         <div class="form-group">
           <label for="serviceTypeName">{{__('service_name')}}</label>
           <input type="text" class="form-control" name="serviceTypeName" id="serviceTypeName" required>
         </div>
           <button type="submit" class="btn btn-success">
                <span class="fa fa-plus" aria-hidden="true"></span> {{__('add')}}
            </button>
        </form>
      </div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-12 ">
            <table class="table table-striped table-bordered text-center bg-default">
            <thead>
                <tr>
                 <th>ID</th>
                 <th>{{__('type_of_service')}}</th>
                 <th>{{__('actions')}}</th>
                </tr>
            </thead>
                <tbody>

                @foreach($services as $service)
                <tr>

                   <td>{{$service->serviceTypeId}}</td>
                   <td>{{$service->serviceTypeName}}</td>
                   <td><a href="{{route('services.edit', ['id' => $service->serviceTypeId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span> {{__('edit')}}
                      </a>
                       <a href="{{route('services.show', ['id' => $service->serviceTypeId])}}" class="btn btn-danger">
                        <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>


     <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
    </div>
</div>
</div>
@endsection
