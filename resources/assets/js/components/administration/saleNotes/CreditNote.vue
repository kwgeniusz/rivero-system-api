<template>
<div>

<div class="panel panel-default col-xs-12">
    <div class="panel-body">

           <div class="row">
             <div class="col-xs-4">
                <p>ID</p>
                <p>FACTURA #:</p>
                <p>REFERENCIA:</p>
                <p>FECHA:</p>
                <p>CLIENTE:</p>
             </div>   <!-- end col-6 -->
    <div class="col-xs-8">
          <p>DETALLES</p> 
        <div class="table-responsive col-xs-12">
          <table class="table table-striped table-bordered text-center bg-info">
            <thead> 
            <tr>  
                <th>#</th>
                <th>SERVICIO</th>  
                <th>UNIDAD</th>
                <th>COSTO</th>
                <th>CANTIDAD</th>
                <th>MONTO</th>
                <th>COMPROMISOS</th>
                <th>ACCION</th>
                <!-- <th></th> -->
            </tr>
            </thead>
          <tbody>   
    <!--    <tr v-for="(item,index) in itemList">
            <td>{{++index}}</td>
            <td>{{item.serviceName}}</td>
            <td>{{item.unit}}</td>
            <td>{{item.unitCost}}</td>
            <td>{{item.quantity}}</td>
            <td>{{item.amount}}</td>
            <td>{{item.subcontractor_inv_detail.length}} SB</td>
            <td> 
             <a @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
           <button class="btn btn-info btn-sm" @click.prevent="moveUp(index)"> 
              <span class="fa fa-angle-double-up" aria-hidden="true"></span>
             </button>
            <button class="btn btn-info btn-sm" @click.prevent="moveDown(index)">
              <span class="fa fa-angle-double-down" aria-hidden="true"></span>
             </button>
           </td> 
         </tr> -->
         </tbody>
        </table>
       </div>
    </div><!-- end table-responsive -->
  </div><!-- end col-6 -->
<hr>
        <div class="row">
          <div class="col-xs-7 ">
  <!-- <form class="form  form-prevent-multiple-submits">

       <div class="alert alert-danger" v-if="errors.length">
         <h4>Errores:</h4>
         <ul>
          <li v-for="error in errors">{{ error }}</li>
         </ul>
       </div>

  <div class="col-xs-offset-2 col-xs-8">
         <div class="form-group ">
            <label for="clientNumberFormat">CODIGO</label>
            <input type="text" class="form-control" id="clientNumberFormat" name="clientNumberFormat" v-model="formClientNumberFormat" disabled="on">
          </div>

              <div class="form-group">
                <label for="formClientName">NOMBRE Y APELLIDO / EMPRESA</label>
                <input type="text" class="form-control" name="formClientName" v-model="formClientName" placeholder="">
              </div>     

              <div class="form-group">
                <label for="formClientAddress">DIRECCION</label>
                <input type="text" class="form-control" name="formClientAddress" v-model="formClientAddress" placeholder="5924 Azalea Ln Dallas, TX 75230">
              </div>

          <div class="form-group ">
            <label for="formContactType">TIPO DE CONTACTO</label>
            <select v-model="formContactType" class="form-control" name="formContactType" id="formContactType">
                  <option  :value="contactType.contactTypeId"  v-for="(contactType) in contactTypes"> {{contactType.contactTypeName}}</option>
            </select>
          </div>

              <div class="col-xs-12 col-lg-6">
              <div class="form-group">
                <label for="formClientPhone">TELEFONO</label>
                <input type="text" class="form-control" name="formClientPhone" v-model="formClientPhone" placeholder="(000) 000 0000" pattern="^([0-9]{3,11})" title="formato: 04124231242">
              </div>
            </div>

            <div class="col-xs-12 col-lg-6">
              <div class="form-group">
                <label for="formClientEmail">CORREO</label>
                <input type="email" class="form-control" name="formClientEmail" v-model="formClientEmail" placeholder="Correo">
              </div>
            </div>

          <div class="col-xs-12">
              <a  @click="createClient()" v-if="btnSubmitForm"  class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  GUARDAR
              </a>
         </div>
   
  </div>
</form> -->

<form class="form-horizontal">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Remember me
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Sign in</button>
    </div>
  </div>
</form>
          </div>
       </div>

    </div>    <!--END PANEL BODY  -->
</div>   <!-- END PANEL DEFAULT -->

</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component FormNewNote mounted.')
        },
    data: function () {
          return {
            errors: [],
            noteName:'',
            btnSubmitForm: false,
          }
    },
   props: {
           prefUrl: { type: String},
    },
    methods: {
       openModal: function (){
          this.$refs.modalNewNote.open()
              this.errors = [];
              this.noteName = '';
              this.btnSubmitForm = true;
        },
       createNote: function() {
          this.errors = [];
       //VALIDATIONS
      if (!this.noteName) {
               this.errors.push('Campo Nota Es Requerido');
             }

        if (!this.errors.length) { 
        this.btnSubmitForm = false;

           let url =this.prefUrl+'notes';
            axios.post(url,{
              noteName: this.noteName,
            }).then(response => {
          console.log(response);
              this.$emit("notecreated");
               toastr.info("Nota Creada")
               this.errors = [];
               this.noteName = '';
               this.btnSubmitForm = true;
               this.$refs.modalNewNote.close();
            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)
               this.btnSubmitForm = true;
              })
           }

         },
     }
}
</script>
