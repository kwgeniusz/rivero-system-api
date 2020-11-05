<template>
<label>
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
       <a class="btn btn-primary btn-sm" @click="openModal()" data-toggle="tooltip" data-placement="top" title="Mover">
          <span class="fa fa-handshake" aria-hidden="true" ></span>
       </a>
  
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <sweet-modal ref="modal">
    <h3 class="bg-primary"><b>NOMBRE DEL ARCHIVO: <br> {{doc.docName}}</b></h3>

      <div class="col-xs-offset-2 col-xs-9">
        <div class="form-group ">
            <label for="formDocTypeNew">Escoja la Seccion a donde desea moverlo:</label>
            <select v-model="formDocTypeNew" class="form-control" name="formDocTypeNew" id="formDocTypeNew">
                  <option value="previous">Previos</option>
                  <option value="processed">Procesados</option>
                  <option value="revised">Revisados</option>
                  <option value="ready">Listos</option>
            </select>
        </div>
              <a class="btn btn-success" @click="success()" v-if="btnSuccess">
                <span class="fa fa-check" aria-hidden="true"></span>  CONFIRMAR
              </a>
      </div>
</sweet-modal>

</label>   
</template>

<script>
    export default {
        
     mounted() {
            console.log('Component Move File mounted.')
           },
     data: function () {
          return {
           formDocTypeNew : '',
           btnSuccess: false,
          }
    },
    props: {
           doc: { type: Object},
          },
    methods: {
       openModal: function (){
             this.btnSuccess = true;
             this.$refs.modal.open()
 
           // axios.get('../receivables/get/'+this.rId).then(response => {
           //       this.receivable        = response.data[0]
           //       console.log(this.receivable)
           //      });
        },
       success: function() {
             this.btnSuccess = false;

            axios.put('/files/move',{
                docId:        this.doc.docId,
                docUrl:       this.doc.docUrl,
                docTypeOld :  this.doc.docType,
                docTypeNew :  this.formDocTypeNew,
            }).then(response => {

                   if (response.data.alert == "error") {
                       toastr.error(response.data.msj)
                              // this.btnSuccess = true;
                   } else {
                       location.reload();
                    // this.$emit("ready");
                    toastr.success(response.data.msj)
                   }
  
            })
           },
         },
     }
</script>