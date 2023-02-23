<template>
  <div>

<div class="col-xs-12" style="margin:10px">
    <div class="col-xs-4">
      
    </div>   

    <div class="col-xs-4">
            <input type="text" placeholder="Buscar" class="form-control" v-model="inputSearch">
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
</div>

            <div class="col-xs-12">
                <div class="panel panel-default">         
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center" style="border: 1px solid #ddd !important;">
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
                           <tbody>
                             <!-- {{searchData}} -->
                             <tr v-for="(receivable, index) in receivableList" :key="receivable.receivableId">
  
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{receivable.client.clientCode}}</td>  
                                <td class="text-left"> {{receivable.client.clientName}} </td>           
                                <td class="text-left"> {{receivable.client.clientAddress}}</td>
                                <td class="text-left"> {{receivable.client.businessPhone}}</td>
                                <td class="text-left"> {{receivable.cuotas}}</td>
                                <td class="text-left"> {{receivable.balanceTotal}}</td>
                                <td> 
                                 <!-- <button v-if="$can('BAB')" @click="editSubcontractor(index,subcontractor.subcontId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>   -->
                                 <!-- <button v-if="$can('BAC')"  @click="deleteSubcontractor(index,subcontractor.subcontId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>   -->
                                 <a v-if="$can('BAB')" :href="'receivables/'+receivable.client.clientId" class="btn btn-sm btn-success" title="Cuentas por Cobrar"><i class="fa fa-dollar-sign"></i></a>
                                </td>
                             </tr>
                             <tr>
                                <td></td>
                                <td></td>  
                                <td></td>           
                                <td></td>
                                <td></td>
                                <td><h3>TOTAL:</h3></td>
                                <td><h3>{{totalReceivable}}</h3></td>
                                <td> </td>
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
                this.receivableList = response.data
                console.log(response.data)
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
             totalReceivable: function (){
              var totalReceivable = 0;

                 this.receivableList.forEach(function(data){
                         totalReceivable = parseFloat(data.balanceTotal) + parseFloat(totalReceivable);
                });

               return totalReceivable.toFixed(2);
            }  
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
