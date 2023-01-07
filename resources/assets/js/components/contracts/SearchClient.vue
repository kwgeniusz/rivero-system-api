<template>
<div>
<!-- INPUT BUSCADOR DE CLIENTES AJAX-->
    <div class="form-group col-xs-12">
        <label for="clientName">CLIENTE</label>
      
        <div class="input-group">
         <input type="hidden" name="clientId" :value="clientId">
         <input class="form-control" @keyup="searchClient()" name="clientName" v-model="clientName" autocomplete="off" :disabled="btnRemove">
          
           <span class="input-group-btn">
             <a class="btn btn-success" v-if="btnAdd" @click="showModal=true"><span class="fa fa-plus" aria-hidden="true"></span></a>
             <addUp-client v-if="showModal" @close="showModal = false" :editId=0 @sendClient="addClient"/>

             <a class="btn btn-danger" @click="removeClient()" v-if="btnRemove"><span class="fa fa-times-circle" aria-hidden="true"></span></a>
          </span>
         </div>

       <div :class="{ sugerencias: this.style }">
         <div class="result" v-for="(item, index) in list" @click="addClient(item.clientId,item.clientCode,item.clientName,item.clientAddress)"> 
           {{item.clientCode}} - {{item.companyName}} ({{item.clientName }})
           </div>
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


    export default {
        
     mounted() {
            console.log('Component SearchClient mounted.')
    //Si Recibo propiedades desde afuera preparame el input busqueda con esos valores
          if(this.cId && this.cName){
              this.clientId = this.cId
              this.clientName = this.cName
              this.btnRemove = true
              this.btnAdd = false
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
            btnAdd: true,
            btnRemove: false,
            showModal:false,

            // switch: 'N',
          }
    },
     props: {
           prefUrl: { type: String},
           cId: { type: Number, default: null},
           cName: { type: String, default: ''},
           cAddress: { type: String, default: ''}
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
       addClient: function (id,clientCode,name,address){
         // console.log(id,name,address)
            this.clientId = id;
            this.clientName = clientCode+'-'+name;
            this.clientAddress = address;
            this.list = ''
            this.style = false
            this.btnRemove = true
            this.btnAdd = false
           
        },
         removeClient: function (){
            this.clientId = '';
            this.clientName = '';
            this.clientAddress = '';
            this.list = ''
            this.style = false
            this.btnRemove = false
            this.btnAdd = true
           
        },
     }
}
</script>

<style lang="scss">
@import '../../../sass/app.scss'
</style>
