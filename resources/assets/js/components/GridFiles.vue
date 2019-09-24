
<template> 
    <div> 

     <vue-upload :contract-id="contractId" :type-doc="typeDoc" @insert="allFiles()"></vue-upload>
     <br>
      <div class="table-responsive">
          <table class="table table-striped table-bordered text-center">
            <thead> 
            <tr>  
                <th>#</th>
                <th>NOMBRE</th>  
                <th>TIPO</th>
                <th>FECHA DE SUBIDA</th>
                <th colspan="2" >ACCION</th>
            </tr>
            </thead>
          <tbody>   
         <tr v-for="(item,index) in list">
            <td>{{++index}}</td>
            <td>{{item.docName}}</td>
            <td>{{item.mimeType}}</td>
            <td>{{ item.dateUploaded| moment("DD/MM/YY,  h:mm:ss a") }}</td> 
            <td>  
             <a :href="'../download/'+item.docId" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Descargar">
                     <span class="fa fa-file" aria-hidden="true"></span> 
            </a>
          <!--    <a @click="editFile(item)" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
            </a> -->
             <a @click="deleteFile(item)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
            <td>
            <modal-preview-document type-doc="processed" :doc-url="item.docUrl" :ext="item.mimeType">
            </modal-preview-document>
            </td>
           </td> 
         </tr>
         </tbody>
        </table>
       </div>

   <sweet-modal ref="modalEdit">
        <h2>Editar:</h2> <br>
            <div class="form-group ">
                <label for="input">Nombre:</label>
                <input type="text" class="form-control" v-model="doc.docName"><br>
              </div>
        <button class="btn btn-primary" >Actualizar</button>
      </sweet-modal>

     <sweet-modal icon="error" overlay-theme="dark" modal-theme="dark" ref="modalDelete">
        <h2>¿Esta seguro de eliminar este archivo?</h2> <br>
        <p>{{doc.docName}}</p>
        <button class="btn btn-danger" @click="sendDelete(doc.docId)">Eliminar</button>
      </sweet-modal>



    </div>
 </template>

 <script>

import modalPreviewDocument from './ModalPreviewDocument.vue'
import vueUpload from './vueUpload.vue'

export default {
        
     mounted() {
            console.log('Component mounted.')
            this.allFiles();
        },
    data: function() {
        return {
            list: {},
            doc: '',
        }
    },
  props: {
           contractId: { type: String},
           typeDoc:{type: String}
    },
  components: {
         modalPreviewDocument
  },
    methods: {
         allFiles: function (){
            var url ='../contract-allFiles/'+this.contractId+'/'+this.typeDoc;
            axios.get(url).then(response => {
             this.list = response.data
            });
        },
          editFile: function(item) {
             this.$refs.modalEdit.open()
             this.doc = item
          },
          deleteFile: function(item) {
             this.$refs.modalDelete.open()
             this.doc= item
          },
          sendUpdate: function(docId) {
    
          },
          sendDelete: function(docId) {
             var url ='../fileDelete/'+docId;
             axios.get(url).then(response => {
               this.$refs.modalDelete.close()
               this.allFiles();
               toastr.success('Archivo Eliminado') 
            });
          },
    }
       // this.$forceUpdate()
}
 </script>
  
