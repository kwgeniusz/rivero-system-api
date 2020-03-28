@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-6 col-offset-xs-1">
        <h3 class="text-danger">
            {{__('are_you_sure_to_eliminate_this_type_of_service?')}}
        </h3>
        <form action="{{Route('projectUses.destroy',['id' => $project[0]->projectUseId])}}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
                        {{ method_field('DELETE') }}
            <div class="form-group">
                <label class="col-sm-2 control-label" for="projectUseId">
                    ID
                </label>
                <div class="col-sm-10">
                    <input class="form-control" disabled="" id="projectUseId" name="projectUseId" type="text" value="{{$project[0]->projectUseId}}">
                    </input>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="projectUseName">
                    {{__('name')}}
                </label>
                <div class="col-sm-10">
                    <input class="form-control" disabled="" id="projectUseName" name="projectUseName" type="text" value="{{$project[0]->projectUseName}}">
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
                    <a class="btn btn-warning" href="{{route('projectUses.index')}}">
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
