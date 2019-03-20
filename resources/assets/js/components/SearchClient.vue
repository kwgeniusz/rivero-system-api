<template>
<div>
<!-- INPUT BUSCADOR DE CLIENTES AJAX-->
    <div class="form-group col-xs-7">
        <label for="clientName">CLIENTE</label>
      
        <div class="input-group">
         <input type="hidden" name="clientId" :value="clientId">
         <input class="form-control" @keyup="searchClient()" name="clientName" v-model="clientName" autocomplete="off" :disabled="btnRemove">
           <span class="input-group-btn">
             <a class="btn btn-success" @click="openModal()" v-if="btnAgg"><span class="fa fa-plus" aria-hidden="true"></span></a>
             <a class="btn btn-danger" @click="removeClient()" v-if="btnRemove"><span class="fa fa-times-circle" aria-hidden="true"></span></a>
          </span>
         </div>

       <div :class="{ sugerencias: this.style }">
         <div class="result" v-for="(item, index) in list" @click="aggClient(item.clientId,item.clientName,item.clientAddress)">{{item.clientName }}</div>
      </div>
  
    </div>
        <!--input Address-->      
          <div class="form-group col-xs-11">
                <label for="siteAddress">DIRECCIÓN</label>
                <input type="text" class="form-control" id="siteAddress" name="siteAddress" v-model="clientAddress">
           </div>


  
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->

 <sweet-modal ref="modalClientNew">

    <h3 class="bg-success"><b>NUEVO CLIENTE</b></h3>
     <br>
       <div class="alert alert-danger" v-if="errors.length">
         <h4>Errores:</h4>
         <ul>
          <li v-for="error in errors">{{ error }}</li>
         </ul>
       </div>
        <div class="col-xs-offset-1 col-xs-10">
              <div class="form-group">
                <label for="formClientName">NOMBRES Y APELLIDOS</label>
                <input type="text" class="form-control" name="formClientName" v-model="formClientName" placeholder="Nombres y Apellidos">
              </div>
              <div class="form-group">
                <label for="formClientDescription">DESCRIPCION</label>
                <input type="text" class="form-control" name="formClientDescription" v-model="formClientDescription" placeholder="Descripción">
              </div>
             
              <div class="form-group">
                <label for="formClientAddress">DIRECCION</label>
                <input type="text" class="form-control" name="formClientAddress" v-model="formClientAddress" placeholder="Direccion">
              </div>
             
              <div class="col-xs-6">
              <div class="form-group">
                <label for="formClientPhone">TELEFONO</label>
                <input type="text" class="form-control" name="formClientPhone" v-model="formClientPhone" placeholder="04124231242" pattern="^([0-9]{3,11})" title="formato: 04124231242">
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label for="formClientEmail">CORREO</label>
                <input type="email" class="form-control" name="formClientEmail" v-model="formClientEmail" placeholder="Correo">
              </div>
            </div>

            <div class="text-center">
              <a @click="createClient()" :disabled="btnSubmitForm"  class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  GUARDAR
              </a>
            </div>
              <br>
  </div>

          
    
         <!--<a class="btn btn-success" slot="button" @click.prevent="$refs.nestedChild.open()">Open Child Modal</a>-->
     </sweet-modal>


     <sweet-modal ref="nestedChild">
              This is the child modal.
     </sweet-modal>

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
            btnSubmitForm: false,

            errors: [],
            formClientName: '',
            formClientDescription : '',
            formClientAddress: '',
            formClientPhone: '',
            formClientEmail: '',
          }
    },
     props: {
           url: { type: String, default: 'C'},
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
                if(this.url == "C"){ 
                  var url ='../searchClients/'+this.clientName;
                }else{
                  var url ='../../searchClients/'+this.clientName;
                }
              axios.get(url).then(response => {
                 this.list = response.data
                 this.style = true
                });
              }
          
         },
       aggClient: function (id,name,address){
            this.clientId = id;
            this.clientName = name;
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

       openModal: function (){
             this.errors = [];
            this.$refs.modalClientNew.open()
        },
       createClient: function() {

          if(this.url == "C"){ 
           var url ='../clients';
         }else{
           var url ='../../clients';
         }
           this.errors = [];
           //VALIDATIONS
           if (!this.formClientName) {
                this.errors.push('Nombre y Apellido es Requerido.');
           }

          if (!this.errors.length) { 
            this.btnSubmitForm = true;
            axios.post(url,{
            clientName: this.formClientName,
            clientDescription : this.formClientDescription,
            clientAddress: this.formClientAddress,
            clientPhone: this.formClientPhone,
            clientEmail: this.formClientEmail
            }).then(response => {
               toastr.info("Cliente Nuevo Insertado")
               this.formClientName = "";
               this.formClientDescription= "";
               this.formClientAddress= "";
               this.formClientPhone= "";
               this.formClientEmail = "";
               this.$refs.modalClientNew.close();
            })
           }

         },
     }
}
</script>


<style scoped>

  .sugerencias{ 
 margin:0px;
 width:100%;
 background:white;  
 border-radius: 3px;   
 border: 1px solid #A5ACB2;
}
.sugerencias > .result {
 padding-left:5%;

}
.sugerencias > .result:hover{
 color:white;
 background-color: #3c8dbd;
 cursor:pointer; 
}

</style>
