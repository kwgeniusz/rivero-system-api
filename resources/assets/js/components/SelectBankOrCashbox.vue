<template>
<div>

          <div class="form-group col-lg-8">
            <label for="payMethodId">METODO DE PAGO</label>
            <select class="form-control" id="payMethodId" name="payMethodId" v-model="payMethodId">
               <option v-for="(item, index) in listPaymentMethods" :value="item.payMethodId">{{item.payMethodName}}</option>
              </select>
           </div>
          
          <div class="form-group col-lg-8" v-if="payMethodId == 2">
            <label for="cashboxId">DESTINO:</label>
             <div> CAJA </div>
             <input type="hidden" name="cashboxId" :value="cashboxId">
          </div>  

           <div class="form-group col-lg-8" v-if="payMethodId != 2">
            <label for="bankId">BANCO</label>
            <select class="form-control" id="bankId" @change="getAccount()" name="bankId" v-model="bankId">
                <option v-for="(item, index) in listBank" :value="item.bankId">{{item.bankName}}</option>
            </select>
          </div>  

          <div class="form-group col-lg-8" v-if="payMethodId != 2">
            <label for="accountId">CUENTA DE DESTINO</label>:<br> 
           <select class="form-control" id="accountId" v-model="accountId" name="accountId">
             <option v-for="(item, index) in listAccount" :value="item.accountId">{{item.accountCodeId}}</option>
            </select>
          </div> 


</div>   
</template>


<script>
    export default {
        
     mounted() {
            console.log('Component SelectBankOrCashbox mounted.')

               axios.get(this.prefUrl+'receivables-paymentMethod').then(response => {
                 this.listPaymentMethods = response.data
                });  

               axios.get(this.prefUrl+'banksByOffice').then(response => {
                 this.listBank = response.data
                 this.bankId = this.listBank[0].bankId;
                 this.getAccount();
                }); 
               
               axios.get(this.prefUrl+'cashboxs').then(response => {
                 this.cashboxId =  response.data[0].cashboxId
                });
           },
     data: function () {
          return {
           listPaymentMethods: {},
           listBank: {},
           listAccount: {},

            // errors: [],
            payMethodId: 1,
            bankId: '',
            cashboxId: '',
            accountId:'',
          }
    },
    props: {
           prefUrl: { type: String,default:null},
          },
    methods: {
        getAccount: function (){
         var url = this.prefUrl+'accounts/'+this.bankId;
            axios.get(url).then(response => {
              this.listAccount = response.data;
              this.accountId = this.listAccount[0].accountId;
            });
        },
     }
}
</script>