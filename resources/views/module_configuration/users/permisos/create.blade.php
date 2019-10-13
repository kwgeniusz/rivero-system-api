@extends('admin.layouts.layout')
@push('css')

@endpush
@section('content')
    <!-- Labels on top Form Block -->
    <div class="block">
        <!-- Labels on top Form Title -->
        <div class="block-title">
            <h2>Nuevo Permiso</h2>
        </div>
        <!-- END Labels on top Form Title -->
        <!-- Labels on top Form Content -->
        <form method="POST" action="{{url('/admin/config/privilegios/permisos')}}" class="form-bordered">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="slug">Nombre</label>
                <input type="text" id="slug" name="name" class="form-control" value="{{old("name")}}" required>
                <span class="help-block">Inserte un nombre para el permiso</span>
            </div>

            <div class="form-group">
                <label for="nombre_permiso">Nombre para mostrar</label>
                <input type="text" id="nombre_permiso" name="display_name" class="form-control" value="{{old("display_name")}}" required>
                <span class="help-block">Inserte un nombre para el permiso</span>
            </div>

            <div class="form-group">
                <label for="descripcion_permiso">Descripcion</label>
                <input type="text" id="descripcion_permiso" name="description" class="form-control" value="{{old("description")}}" required>
                <span class="help-block">Inserte una descripción para el permiso</span>
            </div>

            <div class="form-group form-actions text-right">
                <a href="{{url("/admin/config/privilegios/permisos")}}" class="btn btn-effect-ripple btn-default">Atras</a>
                <button type="submit" class="btn btn-effect-ripple btn-primary">Guardar</button>
            </div>
        </form>
        <!-- END Labels on top Form Content -->
    </div>
    <!-- END Labels on top Form Block -->
@endsection
@push('js')

@endpush