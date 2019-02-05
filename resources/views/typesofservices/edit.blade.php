@extends('layouts.master')

@section('content')

<div class="row">

    <div class="col-xs-5 col-offset-xs-1">
            <h3 class="text-success">{{__('edit_service_type')}}</h3 >
                <form action="{{Route('services.update',['id' => $service[0]->serviceTypeId])}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        
                    <div class="form-group">
                      <label for="serviceTypeId">ID</label>
                        <input type="text" class="form-control" id="serviceTypeId" name="serviceTypeId"  value="{{$service[0]->serviceTypeId}}" disabled>
                    </div>

                    <div class="form-group">
                      <label for="projectName">{{__('type_of_project')}}</label>
                      <select class="form-control" name="projectTypeId">
                    @foreach($projects as $project) 
                        @if ($project->projectTypeId == $service[0]->projectTypeId)
                           <option value="{{$project->projectTypeId}}" selected> {{$project->projectTypeName}} </option>
                        @else
                           <option value="{{$project->projectTypeId}}" > {{$project->projectTypeName}} </option>
                        @endif
                    @endforeach   
                    </select>
                    </div>  
                
                    <div class="form-group">
                      <label for="serviceTypeName" class="col-sm-2 control-label">{{__('name')}}</label>
                        <input type="text" class="form-control" id="serviceTypeName" name="serviceTypeName" value="{{$service[0]->serviceTypeName}}" >
                    </div>

                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">

                          <button type="submit" class="btn btn-primary">
                              <span class="fa fa-check" aria-hidden="true"></span> {{__('update')}}
                          </button>
                       <a href="{{route('services.index')}}" class="btn btn-warning">
                          <span class="fa fa-hand-point-left" aria-hidden="true"></span> {{__('return')}}
                        </a>
           
                      </div>
                    </div>
                  </form>
</div>
</div>

@endsection
