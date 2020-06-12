<template>
<div>
<div class="col-xs-12">
           <div class="form-group col-lg-offset-3 col-lg-3">
            <label for="bankId">BANCO</label>
            <select class="form-control" id="bankId" @change="getAccount()" name="bankId" v-model="bankId">
                <option v-for="(item, index) in listBank" :value="item.bankId">{{item.bankName}}</option>
            </select>
          </div>  

          <div class="form-group col-lg-3">
            <label for="accountId">CUENTA</label>:<br> 
           <select class="form-control" id="accountId" v-model="accountId" name="accountId">
             <option v-for="(item, index) in listAccount" :value="item.accountId">{{item.accountCodeId}}</option>
            </select>
          </div> 
</div>

</div>   
</template>


<script>
    export default {
        
     mounted() {
            console.log('Component SelectBankWithAccount mounted.')

             var url = this.prefUrl+'banksByOffice';
              axios.get(url).then(response => {
                 this.listBank = response.data
                 this.bankId = this.listBank[0].bankId;
                 this.getAccount();
                }); 
           },
     data: function () {
          return {
           listBank: {},
           listAccount: {},

           bankId: '',
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