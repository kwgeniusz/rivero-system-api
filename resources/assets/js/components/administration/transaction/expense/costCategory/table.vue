<template>
       <div class="col-xs-12 col-lg-7 col-lg-offset-2">
                <div class="panel panel-default">
                    <div class="table-responsive text-center">

                        <table class="table table-striped table-bordered text-center">
                            <thead class="bg-danger">
                              <tr>
                                <th>#</th>
                                <!-- <th>CODIGO DE TRANSACCION</th> -->
                                <th>CATEGORIA DE COSTO</th>
                                <th>ACCIONES</th>
                               </tr>
                            </thead>
                     <tbody v-if="costCategoryList.length > 0">  
                      <template v-for="(transaction, index) in costCategoryList">      
                        <tr :key="index">     
                                <td >{{index + 1}}</td>
                                <!-- <td class="text-left"> {{transaction.transactionTypeCode}}</td> -->
                                <td class="text-left"> {{transaction.categoryName}}</td>
                                <td> 
                                  <button @click="toggle(transaction.costCategoryId)" :class="{ opened: opened.includes(transaction.costCategoryId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Ver Detalles"><i class="fa fa-angle-double-down" aria-hidden="true"></i></button>    
                                  <button @click="editTransactionType(index,transaction.costCategoryId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                  <button @click="deleteTransactionType(index,transaction.costCategoryId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                </td>
                         </tr>
                         <tr v-if="opened.includes(transaction.costCategoryId)" >
                            <td></td>
                            <td style="background:#c6e8f4" colspan="3">
                
                           </td>
                        </tr> 
                      </template>
                     </tbody>
                     <tbody v-else>
                        <tr><td colspan="12"><loading></loading></td></tr>
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
                opened: [],
                inputSearch: '',
            }
        },
        props: {
            costCategoryList: {},
        },  
       computed: {
            searchData: function () {
                return this.costCategoryList.filter((transaction) => {
                  return transaction.description.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.reason.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.amount.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.user.fullName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.payment_method.payMethodName.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                })
            }, 
        },   
        methods: {
            editTransactionType(index, id){
                // console.log('index: '+index + ' id: '+ id)
                this.$emit('editData', id)
            },
            deleteTransactionType(index, id){
                if (confirm(`Esta Seguro de Eliminar el Tipo de Expense #${++index}?`) ){
                     axios.delete(`/transaction-types/${id}`).then((response) => {
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
    }//end of methods
}//end of instance
</script>