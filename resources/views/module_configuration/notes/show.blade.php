@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-6 col-offset-xs-1">
        <h3 class="text-danger">
            Esta seguro de Borrar Esta Nota?
        </h3> 
        <h4 class="text-danger">
        Observacion:Afecta a los select de carga de propuestas y facturas.
        </h4>
        <form action="{{Route('notes.destroy',['id' => $note[0]->noteId])}}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
                        {{ method_field('DELETE') }}
           <!--  <div class="form-group">
                <label class="col-sm-2 control-label" for="noteId">
                    ID
                </label>
                <div class="col-sm-10">
                    <input class="form-control" disabled="" id="noteId" name="noteId" type="text" value="{{$note[0]->noteId}}">
                    </input>
                </div>
            </div> -->
            <br>
            <input type="hidden" name="noteId" value='noteId'>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="noteName">
                    NOTA:
                </label>
                <div class="col-sm-10">
                    <input class="form-control" disabled="" id="noteName" name="noteName" type="text" value="{{$note[0]->noteName}}">
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
                    <a class="btn btn-warning" href="{{route('notes.index')}}">
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
