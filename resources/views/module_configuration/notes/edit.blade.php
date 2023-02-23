@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-5 col-offset-xs-1">
        <h3 class="text-success">
            EDITAR NOTA
        </h3>
        <form action="{{Route('notes.update',['id' => $note[0]->noteId])}}" class="form-horizontal" method="POST">
            {{ csrf_field() }}
                        {{ method_field('PUT') }}
            <!-- <div class="form-group">
                <label class="col-sm-2 control-label" for="noteId">
                    ID:
                </label>
                <div class="col-sm-10">
                    <input class="form-control" disabled="" id="noteId" name="noteId" type="text" value="{{$note[0]->noteId}}">
                    </input>
                </div>
            </div> -->
            <input type="hidden" name="noteId" value='{{$note[0]->noteId}}'>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="noteName">
                    NOTA:
                </label>
                <div class="col-sm-10">
                    <input class="form-control" id="noteName" name="noteName" type="text" value="{{$note[0]->noteName}}">
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
