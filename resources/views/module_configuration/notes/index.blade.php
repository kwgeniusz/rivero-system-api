@extends('layouts.master')

@section('content')
<span class="logo-lg "><h3><b>NOTAS</b></h3></span>
<div class="text-center">

<div class="panel-body">

        <div class="row ">
          <div class="col-xs-12">

      <form class="form-inline" action="{{Route('notes.store')}}" method="POST">
      {{csrf_field()}}

         <div class="form-group">
           <label for="noteName">CREA NUEVA NOTA</label>
           <input type="text" class="form-control" name="noteName" id="noteName" required>
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
                 <th>NOTA</th>
                 <th>{{__('actions')}}</th>
                </tr>
            </thead>
                <tbody>
            @php $acum=0; @endphp
                @foreach($notes as $note)
                <tr>
                   <td>{{++$acum}}</td>
                   <td>{{$note->noteName}}</td>
                   <td><a href="{{route('notes.edit', ['id' => $note->noteId])}}" class="btn btn-primary">
                        <span class="fa fa-edit" aria-hidden="true"></span> {{__('edit')}}
                      </a>
                       <a href="{{route('notes.show', ['id' => $note->noteId])}}" class="btn btn-danger">
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
