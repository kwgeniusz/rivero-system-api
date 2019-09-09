@extends('admin.layouts.layout')
@push('css')

@endpush
@section('content')
    <div class="block full">
        <div class="block-title">
            <h4>Listado de Roles</h4>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                @permission('privilegios_crear')
                <a class="btn btn-primary btn-effect-ripple" href="{{ url('/admin/config/privilegios/roles/create') }}"
                   role="button">Nuevo</a>
                @endpermission
            </div>
        </div>
        <div class="row">
            <div class="table-responsive"><br/>
                <div class="container-fluid">
                    <table class="table responsive table_btn table-vcenter dataTable no-footer no-wrap"
                           id="role_table" width="100%">
                        <thead class="">
                        <tr>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Nombre para mostrar</th>
                            <th class="text-center">Descripcion</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@include ('plugins.datatable')
@include('admin.config.privilegios.roles.js.roles')
@endpush