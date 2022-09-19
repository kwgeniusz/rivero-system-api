<template>
  <div >
            <div class="col-xs-12">
                <div class="panel panel-default">          
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-center">
                              <tr class="text-center">
                                <th>#</th>
                                <th>TERMINO LOCAL</th>
                                <th>EMPRESA ENLAZADA</th>
                                <th>TERMINO ENLAZADO</th>
                                <th>ACCIONES</th>            
                               </tr>
                            </thead>
                           <tbody v-if="termEquivalenceList.length > 0">      
                             <tr v-for="(term, index) in termEquivalenceList" :key="index">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{term.termName}} ({{term.hasCost}})</td>
                         
                                <td class="text-left" v-if="term.term_equivalence"> {{term.term_equivalence.destination_company.companyName}}</td>
                                <td class="text-left" v-else> </td>
                                
                                <td class="text-left" v-if="term.term_equivalence"> {{term.term_equivalence.destination_term.termName}} ({{term.term_equivalence.destination_term.hasCost}})</td>
                                <td class="text-left" v-else> </td>
                                <td> 
                                   <!-- <button @click="toggle(term.termId)" :class="{ opened: opened.includes(term.termId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Informacion de otros contactos"><i class="fa fa-user" aria-hidden="true"></i></button>   -->
                                    <!-- <button @click="editData(index,term.termId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>   -->
                                    <button @click="deleteData(index,term.termId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                </td>
                              </tr>                
                          </tbody>
                       <tbody v-else>
                           <tr>
                             <td colspan="12">
                                 <loading></loading>
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
            // console.log(this.term)
        },
        data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            termEquivalenceList: { type: Array},
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
