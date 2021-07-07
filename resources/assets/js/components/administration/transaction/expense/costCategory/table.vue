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
                         <!-- {{costCategoryList}}   -->
                      <template v-for="(transaction, index) in costCategoryList">      
                        <tr :key="index" >     
                                <td >{{index + 1}}</td>
                                <!-- <td class="text-left"> {{transaction.transactionTypeCode}}</td> -->
                                <td  @click="toggle(transaction.costCategoryId)" :class="{ opened: opened.includes(transaction.costCategoryId) }" class="text-left" > 
                                    {{transaction.categoryName}}
                                </td>
                                <td> 
                                  <button @click="editTransactionType(index,transaction.costCategoryId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                  <button @click="deleteTransactionType(index,transaction.costCategoryId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                  <!-- <button class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Ver Detalles"><i class="fa fa-angle-double-down" aria-hidden="true"></i></button>     -->
                                </td>
                         </tr>
                         <tr v-if="opened.includes(transaction.costCategoryId)" >
                            <!-- <td></td> -->
                            <td colspan="3">
                               {{transaction.cost_subcategory}}
                                <div class="ac-sub bg-info">
                                    <input class="ac-input" id="ac-2" name="ac-2" type="checkbox" />
                                    <label class="ac-label" for="ac-2">I love jelly donuts</label>
                                        <div class="ac-sub bg-info">
                                        <input class="ac-input" id="ac-21" name="ac-21" type="checkbox" />
                                         <label class="ac-label" for="ac-21">childres1</label>
                                       </div>
                                    <!-- <article class="ac-sub-text">
                                      <p>But not only is the sea such a foe to man who is an alien to it, but it is also a fiend to its own off-spring; worse than the Persian host who murdered his own guests; sparing not the creatures which itself hath spawned. Like a savage tigress that tossing in the jungle overlays her own cubs, so the sea dashes even the mightiest whales against the rocks, and leaves them there side by side with the split wrecks of ships. No mercy, no power but its own controls it. Panting and snorting like a mad battle steed that has lost its rider, the masterless ocean overruns the globe.</p>
                                      <p>Consider the subtleness of the sea; how its most dreaded creatures glide under water, unapparent for the most part, and treacherously hidden beneath the loveliest tints of azure. Consider also the devilish brilliance and beauty of many of its most remorseless tribes, as the dainty embellished shape of many species of sharks. Consider, once more, the universal cannibalism of the sea; all whose creatures prey upon each other, carrying on eternal war since the world began.</p>
                                   </article> -->
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