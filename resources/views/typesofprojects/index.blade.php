@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b>{{__('type_of_project')}}</b></h3></span>
<div class="text-center">

    <div class="panel-body">

    <div class="row ">
      <div class="col-xs-12">
      <form class="form-inline" action="{{Route('projects.store')}}" method="POST">
      {{csrf_field()}}
         <div class="form-group">
           <label for="projectTypeName">{{__('project_name')}}</label>
           <input type="text" class="form-control" name="projectTypeName" id="projectTypeName" required>
         </div>
           <button type="submit" class="btn btn-success">
                <span class="fa fa-plus" aria-hidden="true"></span>   {{__('add')}}
            </button>
        </form>
      </div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-12 ">
            <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                 <th>ID</th>
                 <th>{{__('TYPES')}}</th>
                 <th>{{__('actions')}}</th>
                </tr>
            </thead>
                <tbody>
                @foreach($projects as $project)
                <tr>
                   <td>{{$project->projectTypeId}}</td>
                   <td>{{$project->projectTypeName}}</td>
                   <td><a href="{{route('projects.edit', ['id' => $project->projectTypeId])}}" class="btn btn-primary">
                    <span class="fa fa-edit" aria-hidden="true"></span> {{__('edit')}}
                      </a>
                       <a href="{{route('projects.show', ['id' => $project->projectTypeId])}}" class="btn btn-danger">
                     <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('delete')}}
                       </a>
                   </td>
                </tr>
                @endforeach
                </tbody>
            </table>

                 <a href="{{route('home')}}" class="btn btn-warning">
                  <span class="fa fa-times-circle" aria-hidden="true"></span>  {{__('return')}}
              </a>
        </div>
    </div>

</div>
</div>

@endsection
