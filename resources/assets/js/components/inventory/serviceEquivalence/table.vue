<template>
  <div >

    <div class="col-xs-4">
    
    </div>   

    <div class="col-xs-4">
      <ul class="list-group">
        <li class="list-group-item">
            <input type="text" placeholder="Buscar" class="form-control" v-model="inputSearch">
        </li>
       </ul>
    </div> 

   <div class="col-xs-4">
      <!-- <a href="{{route('reports.clients')}}" class="btn btn-danger btn-sm text-right">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> Imprimir Clientes de la Corporacion
           </a> -->
        <!-- <div class="dropdown">
          <button  class="btn btn-info btn-sm" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a v-if="$can('FE')" href="/contactTypes">¿Como nos Contacto?</a></li>
          </ul>
        </div>
            -->
    </div>

            <div class="col-xs-12">
                <div class="panel panel-default">          
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-center">
                              <tr class="text-center">
                                <th>#</th>
                                <th>SERVICIO LOCAL</th>
                                <th>EMPRESA ENLAZADA</th>
                                <th>SERVICIO ENLAZADO</th>
                                <th>ACCIONES</th>            
                               </tr>
                            </thead>
                           <tbody v-if="serviceEquivalenceList.length > 0">      
                             <tr v-for="(service, index) in serviceEquivalenceList" :key="index">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{service.serviceName}} ({{service.hasCost}})</td>
                         
                                <td class="text-left" v-if="service.service_equivalence"> {{service.service_equivalence.destination_company.companyName}}</td>
                                <td class="text-left" v-else> </td>
                                
                                <td class="text-left" v-if="service.service_equivalence"> {{service.service_equivalence.destination_service.serviceName}} ({{service.service_equivalence.destination_service.hasCost}})</td>
                                <td class="text-left" v-else> </td>
                                <td> 
                                   <!-- <button @click="toggle(service.serviceId)" :class="{ opened: opened.includes(service.serviceId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Informacion de otros contactos"><i class="fa fa-user" aria-hidden="true"></i></button>   -->
                                    <!-- <button @click="editData(index,service.serviceId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>   -->
                                    <button @click="deleteData(index,service.serviceId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
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
            // console.log(this.service)
        },
        data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            serviceEquivalenceList: { type: Array},
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
