@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-6 col-offset-xs-1">
        <h3 class="text-success">
            EDITAR TIPO DE CONTACTO
        </h3>
        <form action="{{Route('contactTypes.update',['id' => $contactType[0]->contactTypeId])}}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
                        {{ method_field('PUT') }}
            <!-- <div class="form-group">
                <label class="col-sm-2 control-label" for="contactTypeId">
                    ID:
                </label>
                <div class="col-sm-10">
                    <input class="form-control" disabled="" id="contactTypeId" name="contactTypeId" type="text" value="{{$contactType[0]->contactTypeId}}">
                    </input>
                </div>
            </div> -->
            <input type="hidden" name="contactTypeId" value='{{$contactType[0]->contactTypeId}}'>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="contactTypeName">
                    TIPO DE CONTACTO:
                </label>
                <div class="col-sm-9">
                    <input class="form-control" id="contactTypeName" name="contactTypeName" type="text" value="{{$contactType[0]->contactTypeName}}">
                    </input>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-primary" type="submit">
                        <span aria-hidden="true" class="fa fa-check">
                        </span>
                        {{__('update')}}
                    </button>
                    <a class="btn btn-warning" href="{{route('contactTypes.index')}}">
                        <span aria-hidden="true" class="fa fa-hand-point-left">
                        </span>
                        {{__('return')}}
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
