<template>
       <div >



<div class="col-xs-12 col-md-4 col-md-offset-4">
  <ul class="list-group">
    <li class="list-group-item">
        <input type="text" placeholder="Buscar" class="form-control" v-model="inputSearch">
    </li>
   </ul>
</div>   
            <div class="col-xs-12">
                <div class="panel panel-default">          

<!-- <ul class="nav nav-tabs nav-justified">
      <li class="nav-item">
        <a class="nav-link" @click.prevent="setActive('home')" :class="{ active: isActive('home') }" href="#home">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" @click.prevent="setActive('profile')" :class="{ active: isActive('profile') }" href="#profile">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" @click.prevent="setActive('contact')" :class="{ active: isActive('contact') }" href="#contact">Contact</a>
      </li>
    </ul>
    <div class="tab-content py-3" id="myTabContent">
      <div class="tab-pane " :class="{ 'active': isActive('home') }" id="home">Home content</div>
      <div class="tab-pane " :class="{ 'active': isActive('profile') }" id="profile">Profile content</div>
      <div class="tab-pane " :class="{ 'active': isActive('contact') }" id="contact">Contact content</div>
    </div> -->
    <!-- <ul>
    <li v-for="client in clientList" :key="client.id">{{ client.clientName }}</li>
</ul>

<pagination :data="laravelData" @pagination-change-page="getResults"></pagination> -->

                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>CODIGO</th>
                                <th>TIPO</th>
                                  <th>COMPANIA<br>
                                   (RESPONSABLE / CLIENTE)
                                   </th>
                                  <th>GENERO</th>
                                  <th>DIRECCION</th> 
                                  <th>TELEFONO DE NEGOCIO</th> 
                                  <!-- <th>TELEFONO DE CASA</th>  -->
                                  <!-- <th>CELULAR</th>  -->
                                  <th>CORREO</th> 
                                  <th>ACCIONES</th>            
                               </tr>
                            </thead>
                            <tbody v-if="searchData.length > 0">
                             <template v-for="(client, index) in searchData">       
                             <tr>
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{client.clientCode}}</td>
                                <td class="text-left"> {{client.clientType}}</td>
                                <td class="text-left"> 
                               <modal-client-details pref-url="/" 
                               :client-id="client.clientId" 
                               :client-name="client.clientName"
                               :company-name="client.companyName">
                               </modal-client-details>
                                </td>
                                <td class="text-left"> {{client.gender}}</td> 
                                <td class="text-left"> {{client.clientAddress}}</td>  
                                <td class="text-left"> {{client.businessPhone}}</td>
                                <!-- <td class="text-left"> {{client.homePhone}}</td> -->
                                <!-- <td class="text-left"> {{client.mobilePhone}}</td> -->
                                <td class="text-left"> {{client.mainEmail}}</td>
                                <td> 
                                 <button @click="toggle(client.clientId)" :class="{ opened: opened.includes(client.clientId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Informacion de otros contactos"><i class="fa fa-user" aria-hidden="true"></i></button>  
                                 <button @click="editData(index,client.clientId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                 <!-- <button @click="deleteData(index,client.clientId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>  -->
                                </td>
                              </tr>

                         <tr v-if="opened.includes(client.clientId)">
                            <td></td>
                            <td colspan="10">
                               <div >
                                <main-other-contact :client-id="client.clientId"/>
                               </div>  
                            </td>
                        </tr> 

                         </template>                 
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
            // console.log(this.clientList)
        },
        data(){
            return{
                inputSearch: '',
                activeItem: 'home', //para los tags
                opened: [], //para el toogle
            }
        },
        props: {
            clientList: { type: Array},
        },  
        computed: {
            searchData: function () {
                return this.clientList.filter((client) => {

                  if(client.companyName == null ) 
                     client.companyName = 'No Info'
                  if(client.clientName == null ) 
                     client.clientName = 'No Info'
                  if(client.clientAddress == null ) 
                     client.clientAddress = 'No Info'
                  if(client.businessPhone == null ) 
                     client.businessPhone = 'No Info'
                  if(client.mainEmail == null ) 
                     client.mainEmail = 'No Info'
                  
                  // return client.clientName.toLowerCase().includes(this.inputSearch.toLowerCase())
                   return client.companyName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          client.clientName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          client.clientAddress.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          client.businessPhone.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          client.mainEmail.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                  
                })
            } //end of the function searchData
        },
       methods: {
         editData(index, id){
                this.$emit('editData', id)
            },
      //  deleteData(index, id){
      //           if (confirm(`Esta Seguro de Eliminar la Transaccion #${++index}?`) ){
      //               axios.delete(`-/delete/${id}`).then((response) => {
      //                      toastr.success(response.data.message);
      //                      this.$emit('showlist', 0)
      //               })
      //           }    
      //       }, 
        toggle(id) {
         const index = this.opened.indexOf(id);
         if (index > -1) {
           this.opened.splice(index, 1)
         } else {
           this.opened.push(id)
         }
       }, 
       isActive (menuItem) {
        return this.activeItem === menuItem
       },
       setActive (menuItem) {
        this.activeItem = menuItem
       }

      } //end of methods
    }//end of vue instance

</script>
