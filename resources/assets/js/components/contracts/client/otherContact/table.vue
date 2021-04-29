<template>
       <div class="col-xs-12">
                <div class="panel panel-default">          
                    <div class="table-responsive text-center">
                       <table class="table table-striped table-bordered text-center ">
                         
                                         <thead>
                                             <tr class="bg-success">
                                              <th>#</th>
                                              <th>NOMBRE</th>
                                              <th>RELACION</th>
                                              <th>TELEFONO PRINCIPAL</th>
                                              <th>TELEFONO SECUNDARIO</th>
                                              <th>CORREO</th>
                                              <th>CORREO SECUNDARIO</th>               
                                              <th>ACCIONES</th>                 
                                             </tr>
                                         </thead>
                                       <tbody>
                                             <tr v-for="(otherContact,index) in otherContacts" :key="otherContact.otherContactId">
                                                 <td>{{++index}} </td>
                                                 <td>{{otherContact.name}} </td>
                                                 <td>{{otherContact.relationship}} </td>
                                                 <td>{{otherContact.mainPhone}} </td>
                                                 <td>{{otherContact.secondaryPhone}} </td>
                                                 <td>{{otherContact.mainEmail}} </td>
                                                 <td>{{otherContact.secondaryEmail}} </td>
                                                 <td> 
                                                 <button @click="editData(index,otherContact.otherContactId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                                 <button @click="deleteData(index,otherContact.otherContactId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                                 </td>
                                             </tr>
                                     </tbody>
                                   </table>

                    </div>
                </div>
            </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.') 
        },
        data(){
            return{
               
            }
        },
        props: {
            otherContacts: {},
        },  
       methods: {
         editData(index, id){
                this.$emit('editData', id)
            },
          deleteData(index, id){
                if (confirm(`Esta Seguro de Eliminar El Contacto #${index}?`) ){
                    axios.delete(`/other-contacts/${id}`).then((response) => {
                           toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                    })
                }    
            }, 

      } //end of methods
    }//end of vue instance

</script>
