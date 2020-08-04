
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
  <h3>Lista de Archivos</h3>
<div class="gridy">
<div>
  <!-- downloads buttons -->  
     <!--   <a v-if="$can('BDGAC') && typeDoc == 'previous'"  @click="downloadFiles" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" >
           <i class="fa fa-download" aria-hidden="true"></i> Descargar Seleccionados 
       </a>
      <a v-if="$can('BDGBC') && typeDoc == 'processed'"  @click="downloadFiles" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" >
           <i class="fa fa-download" aria-hidden="true"></i> Descargar Seleccionados 
       </a>
      <a v-if="$can('BDGCC') && typeDoc == 'revised'"  @click="downloadFiles" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" >
           <i class="fa fa-download" aria-hidden="true"></i> Descargar Seleccionados 
       </a>
      <a v-if="$can('BDGDC') && typeDoc == 'ready'"  @click="downloadFiles" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" >
           <i class="fa fa-download" aria-hidden="true"></i> Descargar Seleccionados
       </a> -->
</div>
<div>
  <!-- deletes buttons -->  
       <a  v-if="$can('BDGAB') && typeDoc == 'previous'" @click="modalDelete" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" >
           <i class="fa fa-times-circle" aria-hidden="true"></i> Eliminar Seleccionados 
       </a>
      <a v-if="$can('BDGBB') && typeDoc == 'processed'" @click="modalDelete" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" >
           <i class="fa fa-times-circle" aria-hidden="true"></i> Eliminar Seleccionados 
       </a>
      <a  v-if="$can('BDGCB') && typeDoc == 'revised'" @click="modalDelete" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" >
           <i class="fa fa-times-circle" aria-hidden="true"></i> Eliminar Seleccionados 
       </a>
      <a v-if="$can('BDGDB') && typeDoc == 'ready'" @click="modalDelete" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" >
           <i class="fa fa-times-circle" aria-hidden="true"></i> Eliminar Seleccionados 
       </a> 
</div>
</div>
<br>
<!-- {{process}} -->
<!-- <progress-bar></progress-bar> -->
<!-- <progress-bar size="medium" bar-color="#dc720f" :val="process.toString()" :text="process.toString()" :title="process.toString()"/> -->

      <div class="table-responsive">
          <table class="table table-striped table-bordered text-center">
            <thead> 
            <tr>  
                <th><input type="checkbox" v-model="checkAll"> # </th>
                <th>NOMBRE</th>  
                <th>TIPO</th>
                <th>FECHA DE SUBIDA</th>
                <th>SUBIDO POR</th>
                <th colspan="2" >ACCION</th>
            </tr>
            </thead>
       <tbody > 
         <tr v-for="(item,index) in documents">
            <td >
           <label :for="item.docId">
              <input type="checkbox" :id="item.docId" :value="item" v-model="checked" number>
              {{++index}}
          </label>
            </td>
            <td>{{item.docName}}</td>
            <td>{{item.mimeType}}</td>
            <td>{{item.dateUploaded | moment('timezone', 'America/Chicago','MM/DD/YYYY - hh:mm A')}} (Dallas)</td> 
            <td v-for="(user) in item.user"> {{user.fullName}}</td> 
            <td>  

            <a :href="'../fileDownloadByUnit/'+item.docId" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Descarga">
                           <span class="fa fa-file" aria-hidden="true"></span> 
               </a>
            <modal-preview-document :doc-url="item.docUrl" :ext="item.mimeType">
            </modal-preview-document>
           </td> 
         </tr>
         </tbody>

        </table>
       </div>



 <div id="form">
   <form action="../fileDownload" name="vote" method="POST">
    <input type="hidden" name="_token" :value="csrf">
    <input type="hidden" name="checkedFiles" :value="JSON.stringify(checked)" />
   </form>
 </div>

   <sweet-modal ref="modalEdit">
        <h2>Editar:</h2> <br>
            <div class="form-group ">
                <label for="input">Nombre:</label>
                <input type="text" class="form-control" v-model="docSelected.docName"><br>
              </div>
        <button class="btn btn-primary" >Actualizar</button>
   </sweet-modal>

   <sweet-modal icon="error" overlay-theme="dark" modal-theme="dark" ref="modalDelete">
        <h2>¿Esta seguro de eliminar estos archivos?</h2> <br>
        <div class="text-center">
          <p v-for="(file,index) in checked"> {{++index}}) {{file.docName}}</p> 
        </div>
        <button class="btn btn-danger" @click="deleteFiles">Eliminar</button>
  </sweet-modal>


    </div>
 </template>

 <script>

import modalPreviewDocument from '../ModalPreviewDocument.vue'
import ProgressBar from 'vue-simple-progress';

import vueUploadPrevious from './VueUploadPrevious.vue'
import vueUploadProcessed from './VueUploadProcessed.vue'
import vueUploadRevised from './VueUploadRevised.vue'
import vueUploadReady from './VueUploadReady.vue'

export default {
        
     mounted() {
            // console.log('Component mounted.')
          this.$moment.tz.setDefault('UTC')
          this.allFiles();
        },
    data: function() {
        return {
            documents: [],
            checked: [],
            process: 0,

            docSelected: '',
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            // showMultiples: false,
        }
    },
  props: {
           contractId: { type: String},
           typeDoc:{type: String}
    },
  components: {
         modalPreviewDocument,
         ProgressBar,

         vueUploadPrevious,
         vueUploadProcessed,
         vueUploadRevised,
         vueUploadReady

  },
   computed: {
    checkAll: {
      get: function () {
        return this.documents ? this.checked.length == this.documents.length : false;
      },
      set: function (value) {
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
          modalDelete: function() {
             this.$refs.modalDelete.open()
             // this.docSelected= item
          },
          deleteFiles: function() {
            // si this.checked no esta vacio ejecuta la funcion de borra multiple
            if(Object.keys(this.checked).length != 0) {
               var url ='../fileDelete';
               axios.put(url,{
                 checkedFiles :  this.checked,
                  }).then(response => {
                    this.$refs.modalDelete.close()
                    this.allFiles();
                    toastr.success('Archivos Eliminados') 
                  });
             }
          },
          downloadFiles: function() {
            // si this.checked no esta vacio ejecuta la funcion de borra multiple
            if(Object.keys(this.checked).length != 0) {
                  
              // document.getElementById("form").innerHTML = '<form action="../fileDownload" name="vote" method="POST" style="display:none;"><input type="hidden" name="checkedFiles[]" value="'+this.checked+'"/> <input type="hidden" name="_token" value="' + this.csrf + '"> </form>';

              document.forms['vote'].submit();

               // window.location = '../fileDownload/'+JSON.stringify(this.checked);

               // var url ='../fileDownload';

               // axios.put(url,{checkedFiles:this.checked},
               //    {
               //    responseType: 'arraybuffer',
               //    headers: {
               //       'Accept': 'application/octet-stream',
               //    },
               //    onDownloadProgress:  (progressEvent) => {
               //       let percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
               //        console.log(progressEvent.lengthComputable)
               //          this.process = percentCompleted;
               //          console.log(this.process)
               //    }
               //   },
               //  ).then(response => {
                  
               //    let blob = new Blob([response.data], { type: 'application/zip' })
               //    let link = document.createElement('a')
               //    link.href = window.URL.createObjectURL(blob)
               //    link.download = 'files.zip'
               //    link.click();
                   
               //    this.process = 0;
               //    toastr.success('Archivos Descargados') 
               //    });


             }
          },
    }
       // this.$forceUpdate()
}
 </script>
  
<style lang="scss">
@import '../../../../sass/app.scss'
</style>