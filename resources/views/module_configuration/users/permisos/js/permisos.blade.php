<script>
    $(function () {
        var tabla_admin_permisos = $("#permission_table");

        function inicializar() {
            tabla_admin_permisos.DataTable({
                'ajax': {
                    "url": '{{url("/admin/config/privilegios/permisos")}}',
                    "type": "GET",
                    dataSrc: '',
                },
                'columns': [
                    {data: 'name'},
                    {data: 'display_name'},
                    {data: 'description'},
                    {
                        render: function (data, type, row) {
                            var ruta_edit = "{{url('/admin/config/privilegios/permisos/')}}/" + row.id + "/edit";
                            var ruta_destroy = "{{url('/admin/config/privilegios/permisos/')}}/" + row.id;
                            var btn_editar = "";
                            @permission('privilegios_editar')
                                btn_editar += '<a href="' + ruta_edit + '" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></a>';
                            @endpermission
                            var btn_eliminar = "";
                            @permission('privilegios_eliminar')
                                btn_eliminar += '<form method="POST" class="frm-desactivar eliminar-permiso" action="' + ruta_destroy + '">';
                                btn_eliminar += '{{ csrf_field() }}';
                                btn_eliminar += '<input type="hidden" name="_method" value="delete">';
                                btn_eliminar += '<button class="btn btn-sm btn-danger" type="submit" data-toggle="modal" rel="tooltip"  data-original-title="Eliminar"><i class="fa fa-trash"></i></button>';
                                btn_eliminar += '</form>';
                            @endpermission

                            return btn_editar + btn_eliminar;
                        }
                    }
                ]
            });
        }

        inicializar();

        $('body').on('click', 'tbody .eliminar-permiso', function (e) {
            ruta = $(this).attr('action');
            var data = $(this).serialize();
            e.preventDefault();
            swal({
                title: '',
                text: '¿Seguro desea eliminar el registro?',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then(function () {
                $.ajax({
                    url: ruta,
                    type: 'POST',
                    datatype: 'json',
                    data: data,
                    success: function (respuesta) {
                        if (respuesta.success) {
                            tabla_admin_permisos.DataTable().ajax.reload();
                            toastr.success(respuesta.mensaje);
                        } else {
                            toastr.error(respuesta.mensaje);
                        }
                    },
                    error: function (e) {
                        console.log(e);
                        $.each(e.responseJSON.errors, function (index, element) {
                            if ($.isArray(element)) {
                                swal('', element[0], 'error');
                            }
                        });
                    }
                });
            },function(){});

        });
    });
</script>