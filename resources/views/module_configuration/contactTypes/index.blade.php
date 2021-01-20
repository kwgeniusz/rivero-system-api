@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b>¿COMO NOS CONTACTO?</b></h3></span>
<div class="text-center">

<div class="panel-body">

        <div class="row ">
          <div class="col-xs-12">

      <form class="form-inline" action="{{Route('contactTypes.store')}}" method="POST">
      {{csrf_field()}}

         <div class="form-group">
           <label for="contactTypeName">NOMBRE</label>
           <input type="text" class="form-control" name="contactTypeName" id="contactTypeName" required>
         </div>
           <button type="submit" class="btn btn-success">
                <span class="fa fa-plus" aria-hidden="true"></span> {{__('add')}}
            </button>
        </form>
      </div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-9 col-xs-offset-1 ">
            <table class="table table-striped table-bordered text-center bg-default">
            <thead>
                <tr>
                 <th>ID</th>
                 <th>NOMBRE</th>
                 <th>{{__('actions')}}</th>
                </tr>
            </thead>
                <tbody>
            @php $acum=0; @endphp
                @foreach($contactTypes as $contactType)
                <tr>
                   <td>{{++$acum}}</td>
                   <td>{{$contactType->contactTypeName}}</td>
                   <td><a href="{{route('contactTypes.edit', ['id' => $contactType->contactTypeId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span> {{__('edit')}}
                      </a>
                       <a href="{{route('contactTypes.show', ['id' => $contactType->contactTypeId])}}" class="btn btn-danger">
                        <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                        </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>

     <a href="{{route('clients.index')}}" class="btn btn-warning">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
    </div>
</div>
</div>
@endsection
