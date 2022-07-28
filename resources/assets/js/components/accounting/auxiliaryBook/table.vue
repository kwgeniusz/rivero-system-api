<template>
  <div >
            <div class="col-xs-offset-2 col-xs-8">
                <div class="panel panel-default">          
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-center">
                              <tr class="text-center">
                                <th>N.</th>
                                <th>Cuenta</th>
                                <th>Modulo (Entidad)</th>
                                <th>Codigo Auxiliar</th>
                                <th>Nombre del Auxiliar</th>      
                                <th>Acciones</th>      
                               </tr>
                            </thead>
                           <tbody v-if="auxiliaryList.length > 0">      
                             <tr v-for="(auxiliary, index) in auxiliaryList" :key="index">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{auxiliary.general_ledger.accountName}}</td>
                                <td class="text-left"> {{auxiliary.entity.moduleName}} ({{auxiliary.entity.entityName}})</td>
                                <td class="text-left"> {{auxiliary.auxiliaryCode}}</td>  
                                <td class="text-left"> {{auxiliary.auxiliaryName}}</td>
                                <td> 
                                 <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Detalles de Transacciones"><i class="fa fa-user" aria-hidden="true"></i></button>  
                                 <!-- <button @click="editData(index,auxiliary.auxiliaryId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>   -->
                                 <!-- <button @click="deleteData(index,auxiliary.auxiliaryId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>  -->
                                </td>
                              </tr>                
                          </tbody>
                       <tbody v-else>
                           <tr>
                             <td colspan="12">
                                <center> <loading></loading> </center>
                             </td>
                          </tr>
                        </tbody>     
                     </table>

                    </div>
                </div>
                
            </div>
            </div>
        
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.') 
            // console.log(this.auxiliary)
        },
        data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            auxiliaryList: { type: Array},
        },  
        computed: {
  
        },
       methods: {
         editData(index, id){
                this.$emit('editData', id)
            },
         deleteData(index, id){
                if (confirm(`Esta Seguro de Eliminar la Cuenta #${++index}?`) ){
                    axios.delete(`/accounting/general-ledgers/${id}`).then((response) => {
                           toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                    })
                }    
            }, 
  
      } //end of methods
    }//end of vue instance

</script>
