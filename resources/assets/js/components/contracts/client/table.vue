<template>
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
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>CODIGO</th>
                                  <th>COMPANIA</th>
                                  <th>NOMBRE DEL RESPONSABLE</th>
                                  <th>GENERO</th>
                                  <th>DIRECCION</th> 
                                  <th>TELEFONO DE NEGOCIO</th> 
                                  <th>TELEFONO DE CASA</th> 
                                  <th>CELULAR</th> 
                                  <th>CORREO</th> 
                                  <th>ACCIONES</th>            
                               </tr>
                            </thead>
                            <tbody>
                             <template v-for="(client, index) in clientList">       
                             <tr>
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{client.clientCode}}</td>
                                <td class="text-left"> {{client.companyName}}</td>
                                <td class="text-left"> {{client.clientName}}</td>
                                <td class="text-left"> {{client.gender}}</td> 
                                <td class="text-left"> {{client.clientAddress}}</td>  
                                <td class="text-left"> {{client.businessPhone}}</td>
                                <td class="text-left"> {{client.homePhone}}</td>
                                <td class="text-left"> {{client.mobilePhone}}</td>
                                <td class="text-left"> {{client.mainEmail}}</td>
                                <td> 
                                 <button @click="toggle(client.clientId)" :class="{ opened: opened.includes(client.clientId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Informacion de otros contactos"><i class="fa fa-user" aria-hidden="true"></i></button>  
                                 <button @click="editclient(index,client.clientId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                 <button @click="deleteclient(index,client.clientId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                </td>
                              </tr>

                         <tr v-if="opened.includes(client.clientId)">
                            <td></td>
                            <td colspan="9">
                    
                             <!-- <div v-if="transaction.payable != ''">
                                 <h3><b>Cuentas por Pagar Asociadas:</b></h3>
                                    <hr>
                                    <ul v-for="(payable,index) in transaction.payable" :key="payable.payableId">
                                        {{++index}}) <b>Direccion:</b> 
                                       {{payable.subcont_inv_detail.invoice.contract.propertyNumber}} 
                                       {{payable.subcont_inv_detail.invoice.contract.streetName}} 
                                       {{payable.subcont_inv_detail.invoice.contract.streetType}} 
                                       {{payable.subcont_inv_detail.invoice.contract.suiteNumber}} 
                                       {{payable.subcont_inv_detail.invoice.contract.city}} 
                                       {{payable.subcont_inv_detail.invoice.contract.state}} 
                                       {{payable.subcont_inv_detail.invoice.contract.zipCode}}
                                         <br>
                                        <b>Monto Pagado:</b> {{payable.pivot.amountPaid}} <br>
                                        <b>Motivo:</b> {{payable.pivot.reason}}<br>    
                                      </ul>
                                    <hr>
                            </div>   -->
                            </td>
                        </tr> 

                         </template>                 
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
        props: {
            clientList: {},
        },  
        data(){
            return{
                // editMode: -1,
                activeItem: 'home', //para los tags
                opened: [], //para el toogle
            }
        },
        methods: {
       editTransaction(index, id){
                // console.log('index: '+index + ' id: '+ id)
                this.$emit('editData', id)
            },
       deleteTransaction(index, id){
                if (confirm(`Esta Seguro de Eliminar la Transaccion #${++index}?`) ){
                    axios.delete(`-/delete/${id}`).then((response) => {
                           toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                    })
                }    
            }, 
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
