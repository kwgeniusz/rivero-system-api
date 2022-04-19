<template>
  <div>

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
        <div class="dropdown">
          <button  class="btn btn-info btn-sm" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a v-if="$can('FE')" href="#">Imprimir Reporte</a></li>
          </ul>
        </div>
    </div>

            <div class="col-xs-12">
                <div class="panel panel-default">         
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center">
                            <thead class="bg-success">
                              <tr>
                               <th>#</th>
                               <th>COD. CLIENTE</th>
                               <th>NOMBRE</th>
                               <th>DIRECCIÓN</th>
                               <th>TELEFONO</th>
                               <th>CUOTAS</th>
                               <th>DEUDA TOTAL</th>
                               <th>OPCIONES</th>
                              </tr>
                        </thead>
                           <tbody v-if="searchData.length > 0">
                             <tr  v-for="(receivable, index) in searchData" :key="receivable.receivableId">
                                <td >{{index + 1}}</td>
                                <!-- <td class="text-left"> {{receivable.client.clientCode}}</td>   -->
                                <!-- <td class="text-left"> {{receivable.client.clientName}} </td>            -->
                                <!-- <td class="text-left"> {{receivable.client.clientAddress}}</td> -->
                                <!-- <td class="text-left"> {{receivable.client.mainPhone}}</td> -->
                                <!-- <td class="text-left"> {{receivable.mainPhone}}</td> -->
                                <!-- <td class="text-left"> {{receivable.mainEmail}}</td> -->
                                <!-- <td class="text-left"> {{receivable.balanceTotal}}</td> -->
                                <!-- <td class="text-left"> {{receivable.typeForm1099}}</td> -->
                                  <td> 
                      
                                 <button v-if="$can('BAB')" @click="editSubcontractor(index,subcontractor.subcontId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                 <!-- <button v-if="$can('BAC')"  @click="deleteSubcontractor(index,subcontractor.subcontId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>   -->
                                 <a v-if="$can('BAB')" :href="'subcontractors/'+subcontractor.subcontId+'/payables'" class="btn btn-sm btn-success" title="Cuentas por Pagar"><span class="fa fa-user" aria-hidden="true"></span></a> 
                         
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
            axios.get('/receivables').then((response) => {
                // this.receivableList = response.data
                // console.log(response.data)
            })
        },
        data(){
            return{
                receivableList: [],  
                inputSearch: '',
                formStatus: 0,
            }
        },
        computed: {
            searchData: function () {
                return this.receivableList.filter((receivable) => {

                  // if(client.companyName == null ) 
                  //    client.companyName = 'No Info'
                  // if(client.clientName == null ) 
                  //    client.clientName = 'No Info'
                  // if(client.clientAddress == null ) 
                  //    client.clientAddress = 'No Info'
                  // if(client.businessPhone == null ) 
                  //    client.businessPhone = 'No Info'
                  // if(client.mainEmail == null ) 
                  //    client.mainEmail = 'No Info'
                
                  //  return client.companyName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                  //         client.clientName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                  //         client.clientAddress.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                  //         client.businessPhone.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                  //         client.mainEmail.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                  
                })
            } //end of the function searchData
        },
       methods: {
         showlist(n){
                this.formStatus = 0
                axios.get('/receivables').then((response) => {
                    this.receivableList = response.data
                    // console.log(this.receivableList)
                })
            },   
      } //end of methods
    }//end of vue instance

</script>
