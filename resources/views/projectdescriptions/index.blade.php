@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b>{{__('type_of_project')}}</b></h3></span>
<div class="text-center">

    <div class="panel-body">

    <div class="row ">
      <div class="col-xs-12">
      <form class="form-inline" action="{{Route('projectDescriptions.store')}}" method="POST">
      {{csrf_field()}}
         <div class="form-group">
           <label for="projectDescriptionName">{{__('project_name')}}</label>
           <input type="text" class="form-control" name="projectDescriptionName" id="projectDescriptionName" required>
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
                 <th>{{__('description')}}</th>
                 <th>{{__('actions')}}</th>
                </tr>
            </thead>
                <tbody>
                  @php
                   $acum = 0
                  @endphp
                @foreach($projects as $project)
                  @php ($acum += 1)
                <tr>
                   <td>{{$acum}}</td>
                   <td>{{$project->projectDescriptionName}}</td>
                   <td><a href="{{route('projectDescriptions.edit', ['id' => $project->projectDescriptionId])}}" class="btn btn-primary">
                    <span class="fa fa-edit" aria-hidden="true"></span> {{__('edit')}}
                      </a>
                       <a href="{{route('projectDescriptions.show', ['id' => $project->projectDescriptionId])}}" class="btn btn-danger">
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
