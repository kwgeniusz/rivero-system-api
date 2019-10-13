@extends('layouts.master')

@section('content')
<div class="text-center">
    <div class="panel panel-info col-xs-7 col-xs-offset-2">
        <h2 class="bg-danger">
            Reporte de Cobranzas
        </h2>
        <br>
            <div class="col-xs-12">
                <h3 class="text-danger">
                    Error: No existen registros asociados al Rango de Fecha Seleccionado, Intente con otro
                </h3>
            </div>
            <a class="btn btn-warning" href="{{route('collections.index')}}">
                Regresar
            </a>
            <br>
                <br>
                </br>
            </br>
        </br>
    </div>
</div>
@endsection
