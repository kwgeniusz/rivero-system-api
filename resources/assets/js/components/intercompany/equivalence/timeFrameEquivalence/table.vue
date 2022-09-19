<template>
  <div >
            <div class="col-xs-12">
                <div class="panel panel-default">          
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-center">
                              <tr class="text-center">
                                <th>#</th>
                                <th>PERIODO LOCAL</th>
                                <th>EMPRESA ENLAZADA</th>
                                <th>PERIODO ENLAZADO</th>
                                <th>ACCIONES</th>            
                               </tr>
                            </thead>
                           <tbody v-if="timeFrameEquivalenceList.length > 0">      
                             <tr v-for="(time, index) in timeFrameEquivalenceList" :key="index">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{time.timeName}}</td>
                         
                                <td class="text-left" v-if="time.time_frame_equivalence"> {{time.time_frame_equivalence.destination_company.companyName}}</td>
                                <td class="text-left" v-else> </td>
                                
                                <td class="text-left" v-if="time.time_frame_equivalence"> {{time.time_frame_equivalence.destination_time.timeName}} ({{time.time_frame_equivalence.destination_time.hasCost}})</td>
                                <td class="text-left" v-else> </td>
                                <td> 
                                   <!-- <button @click="toggle(time.timeId)" :class="{ opened: opened.includes(time.timeId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Informacion de otros contactos"><i class="fa fa-user" aria-hidden="true"></i></button>   -->
                                    <!-- <button @click="editData(index,time.timeId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>   -->
                                    <button @click="deleteData(index,time.timeId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
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
            // console.log(this.time)
        },
        data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            timeFrameEquivalenceList: { type: Array},
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
