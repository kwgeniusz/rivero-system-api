@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-xs-6 col-offset-xs-1">
            <h3 class="text-danger">{{__('are_you_sure_to_eliminate_this_type_of_project?')}}</h3 >
                <form class="form-horizontal" action="{{Route('projects.destroy',['id' => $project[0]->projectTypeId])}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    <div class="form-group">
                      <label for="projectTypeId" class="col-sm-2 control-label">ID</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="projectTypeId" name="projectTypeId"  value="{{$project[0]->projectTypeId}}" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="projectTypeName" class="col-sm-2 control-label">{{__('name')}}</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="projectTypeName" name="projectTypeName" value="{{$project[0]->projectTypeName}}" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">
                          <span class="fa fa-times-circle" aria-hidden="true"></span> {{__('delete')}}
                          </button>
                       <a href="{{route('projects.index')}}" class="btn btn-warning">
                          <span class="fa fa-hand-point-left" aria-hidden="true"></span> {{__('return')}}
                        </a>
                 
                      </div>
                    </div>
                  </form>
</div>
</div>

@endsection
