<template>
<div>
<!-- paymethodId:{{payMethodId}}
bankId:{{bankId}}
accountId:{{accountId}}
cashboxId:{{cashboxId}} -->
          <div class="form-group col-lg-8">
            <label for="payMethodId">METODO DE PAGO</label>
            <select class="form-control"  id="payMethodId" name="payMethodId" v-model="payMethodId" required>
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
            <select class="form-control"  id="bankId" @change="getAccount()" name="bankId" v-model="bankId" required>
                <option v-for="(item, index) in listBank" :value="item.bankId">{{item.bankName}}</option>
            </select>
          </div>  

          <div class="form-group col-lg-8" v-if="payMethodId != 2">
            <label for="accountId">CUENTA DE DESTINO</label>:<br> 
           <select class="form-control"  id="accountId" name="accountId" v-model="accountId" required>
             <option v-for="(item, index) in listAccount" :value="item.accountId">{{item.accountCodeId}}</option>
            </select>
          </div> 


</div>   
</template>


<script>
    export default {
        
     mounted() {
            console.log('Component SelectBankOrCashbox mounted.')
                       this.payMethodId = this.propPaymethod;
                       this.bankId      = this.propBank;
                       this.accountId   = this.propAccount;
                       this.cashboxId   = this.propCashbox;

              //  axios.get(this.prefUrl+'receivables-paymentMethod').then(response => {
               axios.get('/receivables-paymentMethod').then(response => {
                 this.listPaymentMethods = response.data

                      //  axios.get(this.prefUrl+'banksByOffice').then(response => {
                       axios.get('/banksByOffice').then(response => {
                       this.listBank = response.data
                      //  this.bankId = this.listBank[0].bankId;
                     if(this.bankId > 0){
                        this.getAccount();
                     }  

                          //  axios.get(this.prefUrl+'cashboxs').then(response => {
                           axios.get('/cashboxs').then(response => {
                            this.cashboxId =  response.data[0].cashboxId
                              //  this.payMethodId = 1;
                            });
                      }); 
                });  
           },
     data: function () {
          return {
           listPaymentMethods: {},
           listBank: {},
           listAccount: {},

            // errors: [],
            payMethodId: '',
            bankId: '',
            accountId:'',
            cashboxId: '',
          }
    },
    props: {
          //  prefUrl: { type: String,default:null},
           propPaymethod: {  type: [String,Number], default: null},
           propBank: {  type: [String,Number], default: null},
           propAccount: {  type: [String,Number], default: null},
           propCashbox: {  type: [String,Number], default: null}
          },
    watch: {
     payMethodId: function () {
          if(this.payMethodId == 2){
                this.accountId = '';
                this.bankId    = '';
          }else{
                this.cashboxId = '';
          }
          this.$emit("shareData",this.payMethodId,this.bankId,this.accountId,this.cashboxId);
       }, 
      bankId: function () {
          this.$emit("shareData",this.payMethodId,this.bankId,this.accountId,this.cashboxId);
       },  
      accountId: function () {
          this.$emit("shareData",this.payMethodId,this.bankId,this.accountId,this.cashboxId);
       },   
    },
    methods: {
        getAccount: function (){
        //  var url = this.prefUrl+'accounts/'+this.bankId;
         var url = '/accounts/'+this.bankId;
            axios.get(url).then(response => {
              this.listAccount = response.data;
              // this.accountId = this.listAccount[0].accountId;
            });
            
        },
     }
}
</script>