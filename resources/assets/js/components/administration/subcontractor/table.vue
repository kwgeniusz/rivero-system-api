<template>
<div>

<div>
    <div class="col-xs-4">
     <!-- Total Transacciones: ${{totals.subcontractors}} <br>
     Manuales: ${{totals.manuales}} <br>
     Fee: ${{totals.fee}} <br>
     Total: ${{totals.netTotal}} <br> -->
    </div>   

    <div class="col-xs-4">
      <ul class="list-group">
        <li class="list-group-item">
            <input type="text" placeholder="Buscar" class="form-control" v-model="inputSearch">
        </li>
       </ul>
    </div> 
   <div class="col-xs-4">
    
    </div>
</div>
 <br>

      <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="table-responsive text-center">

                        <table class="table table-striped table-bordered text-center">
                            <thead class="bg-success">
                              <tr>
                                  <th>#</th> 
                                  <th>TIPO TAX ID</th> 
                                  <th># TAX ID</th> 
                                  <th>NOMBRE</th>
                                  <th>TIPO</th>
                                  <th>REPRESENTANTE</th>
                                  <th>DIRECCION</th>
                                  <th>TELEFONO</th>
                                  <th>CORREO</th> 
                                  <th>SERVICIO QUE OFRECE</th>
                                  <th>TIPO 1099</th> 
                                  <th>ACCIONES</th> 
                              </tr>
                            </thead>
                            <tbody v-if="searchData.length > 0">
                             <tr  v-for="(subcontractor, index) in searchData" :key="subcontractor.subcontractorId">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> 
                                    {{subcontractor.subcontractorDate | moment("MM/DD/YYYY hh:mm A")}}
                                    {{subcontractor.subcontractorDateLocal}}
                                    </td>
                                <td class="text-left"> {{subcontractor.description}} <br>
                                 <!-- <p v-if="subcontractor.subcontractorable != null">
                                    {{subcontractor.subcontractorable.contract.siteAddress}}
                                    </p> -->
                                
                                </td>
                                <td class="text-left"> 
                                    <p v-if="subcontractor.subcontractorable  != null"> 
                                    {{subcontractor.subcontractorable.invId}}
                                    </p> 
                                </td>
                                <td class="text-left"> {{subcontractor.reason}}</td>  
                                <td class="text-left"> {{subcontractor.payment_method.payMethodName}} {{subcontractor.payMethodDetails}}</td>           
                               <td class="text-left"> {{subcontractor.amount}}</td>   
                                 <td class="text-left"> 
                                   <p v-if="subcontractor.cashboxId == null" class="text-left"> 
                                    {{subcontractor.account.bank.bankName}}<br> {{subcontractor.account.accountCodeId}} 
                                    </p>
                                     <p v-else class="text-left"> 
                                       CASHBOX
                                     </p>                                          
                                </td>    
                               <td class="text-left">{{subcontractor.user.fullName}}</td>
                                  <td> 
                                     <div v-if="subcontractor.subcontractorable_id == null">
                                        <button @click="editSubcontractor(index,subcontractor.subcontractorId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                        <button @click="deleteSubcontractor(index,subcontractor.subcontractorId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                    </div>  
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
            console.log(this.subcontractorCodes)
            // console.log(this.subcontractorList)
        },
     data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            subcontractorList:  {  type: [Array], default: null},
            subcontractorCodes:  {  type: [Array], default: null},
        },  
         computed: {
            searchData: function () {
                return this.subcontractorList.filter((subcontractor) => {
                  return subcontractor.description.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         subcontractor.reason.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         subcontractor.amount.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         subcontractor.user.fullName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         subcontractor.payment_method.payMethodName.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                })
            }, 
        totals: function (){
              var totalManual = 0;
              var totalsubcontractor = 0;
              var totalFee = 0;
              var netTotal = 0;

              var that = this; // Work around!
                 this.searchData.forEach(function(data){
                      if(data.subcontractorTypeId == that.subcontractorCodes[0].subcontractorTypeId) {
                         if(data.subcontractorable == null){
                          totalManual = parseFloat(totalManual) + parseFloat(data.amount);
                          }
                         else{
                          totalsubcontractor = parseFloat(totalsubcontractor) + parseFloat(data.amount);
                          }
                       }else if(data.subcontractorTypeId == that.subcontractorCodes[1].subcontractorTypeId) {
                          totalFee = parseFloat(totalFee) + parseFloat(data.amount);
                        }
                });
               netTotal = totalsubcontractor + totalManual + totalFee;

              return {
              'subcontractors': totalsubcontractor.toFixed(2),
              'manuales': totalManual.toFixed(2),
              'fee': totalFee.toFixed(2),
              'netTotal': netTotal.toFixed(2)}
         
                // return `Ingresos de Facturas ${suma.toFixed(2)}`;
            }  
        },
        methods: {
            editSubcontractor(index, id){
                // console.log('index: '+index + ' id: '+ id)
                this.$emit('editData', id)
            },
            deleteSubcontractor(index, id){
                if (confirm(`Esta Seguro de Eliminar Al Subcontratista #${++index}?`) ){
                    axios.delete(`/subcontractors/${id}`).then((response) => {
                           toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                    })
                }    
            }, 
        }
    }

</script>