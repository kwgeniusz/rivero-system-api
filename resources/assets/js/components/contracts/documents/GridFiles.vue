
<template> 
    <div> 
   
    <div v-if="$can('BDGAA')">
     <vue-upload-previous v-if="typeDoc == 'previous'" :contract-id="contractId" :type-doc="typeDoc" @insert="allFiles()"></vue-upload-previous>
    </div>
    
    <div v-if="$can('BDGBA')">  
     <vue-upload-processed v-if="typeDoc == 'processed'" :contract-id="contractId" :type-doc="typeDoc" @insert="allFiles()"></vue-upload-processed>
    </div>
     
    <div v-if="$can('BDGCA')">   
     <vue-upload-revised v-if="typeDoc == 'revised'" :contract-id="contractId" :type-doc="typeDoc" @insert="allFiles()"></vue-upload-revised>
    </div>

    <div v-if="$can('BDGDA')">    
     <vue-upload-ready v-if="typeDoc == 'ready'" :contract-id="contractId" :type-doc="typeDoc" @insert="allFiles()"></vue-upload-ready>
    </div>

     <br>

      <div class="table-responsive">
          <table class="table table-striped table-bordered text-center">
            <thead> 
            <tr>  
                <th><input v-if="showMultiples" type="checkbox" v-model="checkAll"> # </th>
                <th>NOMBRE</th>  
                <th>TIPO</th>
                <th>FECHA DE SUBIDA</th>
                <th>SUBIDO POR:</th>
                <th colspan="2" >ACCION</th>
            </tr>
            </thead>
          <tbody>   
         <tr v-for="(item,index) in documents">
            <td v-if="!showMultiples">{{++index}}</td>
            <td v-if="showMultiples">
           <label :for="item.docId">
              <input type="checkbox" :id="item.docId" :value="item" v-model="checked" number>
              {{++index}}
          </label>
            </td>
            <td>{{item.docName}}</td>
            <td>{{item.mimeType}}</td>
            <td>{{item.dateUploaded| moment("MM/DD/YYYY,  h:mm:ss a") }}</td> 
            <td v-for="(user) in item.user"> {{user.fullName}}</td> 
            <td>  
          <!-- downloads buttons -->
             <a v-if="$can('BDGAC') && typeDoc == 'previous'" :href="'../fileDownload/'+item.docId" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Descargar">
                     <span class="fa fa-file" aria-hidden="true"></span> 
            </a>
            <a v-if="$can('BDGBC') && typeDoc == 'processed'" :href="'../fileDownload/'+item.docId" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Descargar">
                     <span class="fa fa-file" aria-hidden="true"></span> 
            </a>
            <a v-if="$can('BDGCC') && typeDoc == 'revised'" :href="'../fileDownload/'+item.docId" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Descargar">
                     <span class="fa fa-file" aria-hidden="true"></span> 
            </a>
            <a v-if="$can('BDGDC') && typeDoc == 'ready'" :href="'../fileDownload/'+item.docId" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Descargar">
                     <span class="fa fa-file" aria-hidden="true"></span> 
            </a>
          <!-- deletes buttons -->

             <a v-if="$can('BDGAB') && typeDoc == 'previous'" @click="deleteFile(item)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
            <a v-if="$can('BDGBB') && typeDoc == 'processed'" @click="deleteFile(item)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
             <a v-if="$can('BDGCB') && typeDoc == 'revised'" @click="deleteFile(item)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
             <a v-if="$can('BDGDB') && typeDoc == 'ready'" @click="deleteFile(item)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
            <modal-preview-document :doc-url="item.docUrl" :ext="item.mimeType">
            </modal-preview-document>
           </td> 
         </tr>
         </tbody>
        </table>
       </div>
<!-- <div class="text-center">
       <a  @click="showMultiples = !showMultiples" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" >
           <span class="fa fa-times-circle" aria-hidden="true"> Activar Multiple Seleccion</span> 
       </a>
       <a  @click="" v-if="showMultiples" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" >
           <span class="fa fa-file" aria-hidden="true"> Descargar Seleccionados</span> 
       </a>
       <a  @click="deleteVariousFiles" v-if="showMultiples" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" >
           <span class="fa fa-times-circle" aria-hidden="true"> Eliminar Seleccionados</span> 
       </a>

</div> -->

   <sweet-modal ref="modalEdit">
        <h2>Editar:</h2> <br>
            <div class="form-group ">
                <label for="input">Nombre:</label>
                <input type="text" class="form-control" v-model="docSelected.docName"><br>
              </div>
        <button class="btn btn-primary" >Actualizar</button>
      </sweet-modal>

     <sweet-modal icon="error" overlay-theme="dark" modal-theme="dark" ref="modalDelete">
        <h2>¿Esta seguro de eliminar este archivo?</h2> <br>
        <p>{{docSelected.docName}}</p>
        <button class="btn btn-danger" @click="sendDelete(docSelected.docId)">Eliminar</button>
      </sweet-modal>


    </div>
 </template>

 <script>

import modalPreviewDocument from '../ModalPreviewDocument.vue'

import vueUploadPrevious from './VueUploadPrevious.vue'
import vueUploadProcessed from './VueUploadProcessed.vue'
import vueUploadRevised from './VueUploadRevised.vue'
import vueUploadReady from './VueUploadReady.vue'

export default {
        
     mounted() {
            console.log('Component mounted.')
            this.allFiles();
        },
    data: function() {
        return {
            documents: [],
            checked: [],

            docSelected: '',
            showMultiples: false,
        }
    },
  props: {
           contractId: { type: String},
           typeDoc:{type: String}
    },
  components: {
         modalPreviewDocument,

         vueUploadPrevious,
         vueUploadProcessed,
         vueUploadRevised,
         vueUploadReady

  },
   computed: {
    checkAll: {
      get: function () {
        console.log('get');
        return this.documents ? this.checked.length == this.documents.length : false;
      },
      set: function (value) {
        console.log('set');

        var checked = [];
        if (value) {
          this.documents.forEach(function (doc) {
            checked.push(doc);
          });
        }
        this.checked = checked;
      }
    }
  },
    methods: {
         allFiles: function (){
            var url ='../contract/'+this.contractId+'/files/'+this.typeDoc;
            axios.get(url).then(response => {
             this.documents = response.data
            // console.log(this.documents[2].user[0].fullName)
            });
        },
          deleteVariousFiles: function() {
            // si this.checked no esta vacio ejecuta la funcion de borra multiple
            alert(this.checked);
          },
          deleteFile: function(item) {
             this.$refs.modalDelete.open()
             this.docSelected= item
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
  
