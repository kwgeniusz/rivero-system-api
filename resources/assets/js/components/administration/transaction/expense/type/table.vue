<template>
   <div>
       <div class="col-xs-12 col-lg-7 col-lg-offset-2">
                <div class="panel panel-default">
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center">
                            <thead class="bg-danger">
                              <tr>
                                <th>#</th>
                                <!-- <th>CODIGO DE TRANSACCION</th> -->
                                <th>NOMBRE DEL TIPO DE TRANSACCION</th>
                                <th>ACCIONES</th>
                               </tr>
                            </thead>
                     <tbody v-if="transactionTypeList.length > 0">       
                      <tr v-for="(transaction, index) in transactionTypeList" :key="index">
                                <td >{{index + 1}}</td>
                                <!-- <td class="text-left"> {{transaction.transactionTypeCode}}</td> -->
                                <td class="text-left"> {{transaction.transactionTypeName}}</td>
                                <td> 
                                  <button v-if="!transaction.transactionTypeCode" @click="editTransactionType(index,transaction.transactionTypeId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                  <button v-if="!transaction.transactionTypeCode" @click="deleteTransactionType(index,transaction.transactionTypeId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
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
        },
        data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            transactionTypeList: {},
        },  
       computed: {
            searchData: function () {
                return this.transactionTypeList.filter((transaction) => {
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
        }
    }

</script>