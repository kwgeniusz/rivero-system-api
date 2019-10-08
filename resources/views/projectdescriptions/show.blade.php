@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-xs-6 col-offset-xs-1">
            <h3 class="text-danger">{{__('are_you_sure_to_eliminate_this_type_of_project?')}}</h3 >
                <form class="form-horizontal" action="{{Route('projectDescriptions.destroy',['id' => $project[0]->projectDescriptionId])}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    <div class="form-group">
                      <label for="projectDescriptionId" class="col-sm-2 control-label">ID</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="projectDescriptionId" name="projectDescriptionId"  value="{{$project[0]->projectDescriptionId}}" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="projectDescriptionName" class="col-sm-2 control-label">{{__('name')}}</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="projectDescriptionName" name="projectDescriptionName" value="{{$project[0]->projectDescriptionName}}" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">
                          <span class="fa fa-times-circle" aria-hidden="true"></span> {{__('delete')}}
                          </button>
                       <a href="{{route('projectDescriptions.index')}}" class="btn btn-warning">
                          <span class="fa fa-hand-point-left" aria-hidden="true"></span> {{__('return')}}
                        </a>
                 
                      </div>
                    </div>
                  </form>
</div>
</div>

@endsection
