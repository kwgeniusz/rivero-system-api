<template>
<div>
<!-- INPUT BUSCADOR DE CLIENTES AJAX-->
    <div class="form-group col-xs-9 col-lg-7 ">
        <label for="clientName">CLIENTE</label>
      
        <div class="input-group">
         <input type="hidden" name="clientId" :value="clientId">
         <input class="form-control" @keyup="searchClient()" name="clientName" v-model="clientName" autocomplete="off" :disabled="btnRemove">
           <span class="input-group-btn">
             <form-new-client :prefUrl="prefUrl"  v-if="btnAgg" @sendClient="aggClient"/>
             <a class="btn btn-danger" @click="removeClient()" v-if="btnRemove"><span class="fa fa-times-circle" aria-hidden="true"></span></a>
          </span>
         </div>

       <div :class="{ sugerencias: this.style }">
         <div class="result" v-for="(item, index) in list" @click="aggClient(item.clientId,item.clientCode,item.clientName,item.clientAddress)"> {{item.clientCode}} - {{item.clientName }}</div>
      </div>
  
    </div>
        <!--input Address-->      
<!--           <div class="form-group col-xs-11">
                <label for="siteAddress">DIRECCIÓN</label>
                <input type="text" class="form-control" id="siteAddress" name="siteAddress" v-model="clientAddress">
           </div>
 -->


</div>   
</template>

<script>

import FormNewClient from './FormNewClient.vue'

    export default {
        
     mounted() {
            console.log('Component SearchClient mounted.')
    //Si Recibo propiedades desde afuera preparame el input busqueda con esos valores
          if(this.cId && this.cName){
              this.clientId = this.cId
              this.clientName = this.cName
              this.btnRemove = true
              this.btnAgg = false
            }
           if(this.cAddress){
            this.clientAddress = this.cAddress
          }

        },
     data: function () {
          return {
            clientId: '',
            clientName : '',
            clientAddress:'',
            list : '',
            style : '',
            btnAgg: true,
            btnRemove: false,

            // switch: 'N',
          }
    },
     props: {
           prefUrl: { type: String},
           cId: { type: Number, default: null},
           cName: { type: String, default: ''},
           cAddress: { type: String, default: ''}
    },
     components: {
         FormNewClient
  },
    methods: {
       searchClient: function() {
           if(this.clientName == '') {
                 this.list = ''
                 this.style =false
           } else { 

              var url =this.prefUrl+'searchClients/'+this.clientName;
              axios.get(url).then(response => {
                 this.list = response.data
                 this.style = true
                });
              }
          
         },
       aggClient: function (id,clientCode,name,address){
         // console.log(id,name,address)
            this.clientId = id;clientCode;
            this.clientName = clientCode+'-'+name;
            this.clientAddress = address;
            this.list = ''
            this.style = false
            this.btnRemove = true
            this.btnAgg = false
           
        },
         removeClient: function (){
            this.clientId = '';
            this.clientName = '';
            this.clientAddress = '';
            this.list = ''
            this.style = false
            this.btnRemove = false
            this.btnAgg = true
           
        },
     }
}
</script>

<style lang="scss">
@import '../../../sass/app.scss'
</style>
