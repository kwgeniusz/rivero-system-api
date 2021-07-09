<template>
       <div class="col-xs-12 col-lg-7 col-lg-offset-2">
                <div class="panel panel-default">
                    <div class="table-responsive text-center">

                        <table class="table table-striped table-bordered text-center">
                            <thead class="bg-danger">
                              <tr>
                                <th>CATEGORIA DE COSTO</th>
                                <th>ACCIONES</th>
                               </tr>
                            </thead>
                     <tbody v-if="costCategoryList.length > 0">
                      <template v-for="(transaction, index1) in costCategoryList">      
                        <tr :key="index1" >     
                                <td class="text-left" @click="toggle(transaction.costCategoryId)" :class="{ opened: opened.includes(transaction.costCategoryId) }" > 
                                   <b>({{transaction.costCategoryCode}}) {{transaction.categoryName}}</b>
                                </td>
                                <td> 
                                  <button @click="editTransactionType(index1,transaction.costCategoryId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                  <button @click="deleteTransactionType(index1,transaction.costCategoryId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                  <!-- <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Ver Detalles"><i class="fa fa-angle-double-down" aria-hidden="true"></i></button>     -->
                                </td>
                         </tr>
                         <tr v-if="opened.includes(transaction.costCategoryId)" >
                            <!-- <td></td> -->
                            <td colspan="2">
<div v-for="(subcategory,index2) in transaction.all_cost_subcategory" :key="subcategory.costCategoryId">        
 <div class="bg-primary hover round glow text-left" role="button">
    <b data-toggle="collapse" aria-expanded="false" :href="'#'+subcategory.costCategoryId+'-scope'"> 

       <i class="fa fa-chevron-circle-down"></i>({{subcategory.costCategoryCode}}) - {{subcategory.categoryName}} 
       <a @click="editTransactionType(index,transaction.costCategoryId)"  title="Editar"><i class="fa fa-edit"></i></a>  
       <a @click="deleteTransactionType(index,transaction.costCategoryId)"  title="Eliminar"><i class="fa fa-times-circle"></i></a> 
    </b>
 </div>
 <div  class="collapse" :id="subcategory.costCategoryId+'-scope'">
  <div class="well">
     <div class="bg-primary hover round glow" role="button"> 
     <div v-for="(subcategory2,index3) in subcategory.all_cost_subcategory" >
            <!-- collapse -->
             <div class="text-left" role="button" data-toggle="collapse" :href="'#'+subcategory2.costCategoryId+'-request'" aria-expanded="false" style="" >
                    <b>({{subcategory2.costCategoryCode}}) - {{subcategory2.categoryName}}</b>
              </div>
                 <!-- collapse -->
              <div  class="collapse" :id="subcategory2.costCategoryId+'-request'">
              </div>

        </div>
        </div>
  </div>
</div>

</div>

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