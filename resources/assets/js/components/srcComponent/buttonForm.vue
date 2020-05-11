<template>
<!-- buttonType == 0 para mostras en listas de detalles agregar y regresar -->
<!-- buttonType ==1 para Guardar y cancelar-->
<!-- buttonType ==2 para actualizar y cancelar -->

<!-- v-on:click="addForm" === 1 para cargar vistas agregar -->
<!-- v-on:click="addForm" === 2 para Guardar registros de la vistas agregar -->
<!-- v-on:click="addForm" === 3 para actualizar registros  -->
<!-- v-on:click="addForm" === 4 para regresar a vistas indicadas por el programador  -->
<!-- v-on:click="addForm" === 5 para cancelar datos de guardado o actualizado, y regresar a listas detalles  -->
        <div class="form-group col-ms-12 col-md-12 col-lg-12 text-center">
            <button v-if="buttonType === 0" v-on:click="addForm(1)" type="button" class="btn btn-success">Agregar</button>
            <button v-if="buttonType === 1" v-on:click="addForm(2)" type="submit" class="btn btn-success">Guardar</button>
            <button v-if="buttonType === 2" v-on:click="addForm(3)" type="submit" class="btn btn-primary">Actualizar</button>
            <button v-if="buttonType === 0" v-on:click="addForm(4)" type="button"  class="btn btn-warning">Regresar</button>
            <button v-if="buttonType === 1 || buttonType === 2" v-on:click="addForm(5)" type="button" class="btn btn-warning">Regresar</button>
        </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            addForm(n){
                console.log(n)
                switch (n) {
                    case 1:
                        this.$emit('addf', n)
                        break;
                    case 2:
                        
                        break;
                    case 3:
                        this.$emit('addUpdate',n)
                        break;
                    case 4:
                        this.$emit('cancDetail', 0)
                        break;
                    case 5:
                        // console.log("entro case")
                        this.$emit('cancf', 0)
                        break;
                
                    default:
                        break;
                }
                
            }
        },
        props: {
            buttonType:{
                type: Number,
                default: 0,
            }
        }
    }
    
</script>