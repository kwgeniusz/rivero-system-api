@extends('admin.layouts.layout')
@push('css')

@endpush
@section('content')
    <!-- Labels on top Form Block -->
    <div class="block">
        <!-- Labels on top Form Title -->
        <div class="block-title">
            <h2>Nuevo Rol</h2>
        </div>
        <!-- END Labels on top Form Title -->

        <!-- Labels on top Form Content -->
        <form method="POST" action="{{url('/admin/config/privilegios/roles')}}" class="form-bordered">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="slug">Nombre</label>
                <input type="text" id="slug" name="name" class="form-control" value="{{old("name")}}" required>
            </div>

            <div class="form-group">
                <label for="nombre_rol">Nombre para mostrar</label>
                <input type="text" id="nombre_rol" name="display_name" class="form-control" value="{{old("display_name")}}" required>
            </div>

            <div class="form-group">
                <label for="descripcion_rol">Descripcion</label>
                <input type="text" id="descripcion_rol" name="description" class="form-control" value="{{old("description")}}" required>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="" class="col-md-12">Permisos</label>
                    @foreach($permisos as $key => $permiso)
                        <div class="col-md-6">
                            <label for="permiso_{{$permiso->id}}" class="checkbox-inline">
                                <input type="checkbox" id="permiso_{{$permiso->id}}" name="permisos[]" value="{{$permiso->id}}">{{$permiso->display_name}}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group form-actions text-right">
                <a href="{{url("/admin/config/privilegios/roles")}}" class="btn btn-effect-ripple btn-default">Atras</a>
                <button type="submit" class="btn btn-effect-ripple btn-primary">Guardar</button>
            </div>
        </form>
        <!-- END Labels on top Form Content -->
    </div>
    <!-- END Labels on top Form Block -->
@endsection
@push('js')

@endpush