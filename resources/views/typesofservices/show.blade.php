@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-6 col-offset-xs-1">
        <h3 class="text-danger">
            {{__('are_you_sure_to_eliminate_this_type_of_service?')}}
        </h3>
        <form action="{{Route('services.destroy',['id' => $service[0]->serviceTypeId])}}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
                        {{ method_field('DELETE') }}
            <div class="form-group">
                <label class="col-sm-2 control-label" for="serviceTypeId">
                    ID
                </label>
                <div class="col-sm-10">
                    <input class="form-control" disabled="" id="serviceTypeId" name="serviceTypeId" type="text" value="{{$service[0]->serviceTypeId}}">
                    </input>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="serviceTypeName">
                    {{__('name')}}
                </label>
                <div class="col-sm-10">
                    <input class="form-control" disabled="" id="serviceTypeName" name="serviceTypeName" type="text" value="{{$service[0]->serviceTypeName}}">
                    </input>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button class="btn btn-danger" type="submit">
                        <span aria-hidden="true" class="fa fa-times-circle">
                        </span>
                        {{__('delete')}}
                    </button>
                    <a class="btn btn-warning" href="{{route('services.index')}}">
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
