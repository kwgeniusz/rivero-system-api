
<template> 
    <div> 
   
    <div v-if="$can('BDGAA')">
     <vue-upload-precontract v-if="typeDoc == 'previous'" :precontract-id="precontractId" :type-doc="typeDoc" @insert="getAllFiles()"></vue-upload-precontract>
    </div>
     <br>

  <h3>Lista de Archivos</h3>
<div class="gridy">
<div>
  <!-- downloads buttons -->  
       <!-- <a v-if="$can('BDGAC') && typeDoc == 'previous'"  @click="downloadFiles" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" >
           <i class="fa fa-download" aria-hidden="true"></i> Descargar Seleccionados 
       </a> -->
</div>
<div>
  <!-- deletes buttons -->  
       <a  v-if="$can('BDGAB') && typeDoc == 'previous'" @click="modalDelete" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" >
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

            <a :href="'/files/'+item.docId+'/download/'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Descarga">
                           <span class="fa fa-file-download" aria-hidden="true"></span> 
               </a>
            <modal-preview-document :doc-url="item.docUrl" :ext="item.mimeType">
            </modal-preview-document>
           </td> 
         </tr>
         </tbody>

        </table>
       </div>
<!-- 


 <div id="form">
   <form action="../fileDownload" name="vote" method="POST">
    <input type="hidden" name="_token" :value="csrf">
    <input type="hidden" name="checkedFiles" :value="JSON.stringify(checked)" />
   </form>
 </div>
 -->
<!--    <sweet-modal ref="modalEdit">
        <h2>Editar:</h2> <br>
            <div class="form-group ">
                <label for="input">Nombre:</label>
                <input type="text" class="form-control" v-model="docSelected.docName"><br>
              </div>
        <button class="btn btn-primary" >Actualizar</button>
   </sweet-modal> -->

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

import ProgressBar from 'vue-simple-progress';
import modalPreviewDocument from '../../ModalPreviewDocument.vue'
import vueUploadPrecontract from './VueUploadPrecontract.vue'

export default {
        
     mounted() {
            // console.log('Component mounted.')
          this.$moment.tz.setDefault('UTC')
          this.getAllFiles();
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
           precontractId: { type: String},
           typeDoc:{type: String}
    },
  components: {
         ProgressBar,
         modalPreviewDocument,
         vueUploadPrecontract,

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
         getAllFiles: function (){
            // var url ='../precontracts/'+this.precontractId+'/files/'+this.typeDoc;
            var url ='/precontracts/'+this.precontractId+'/files';
            axios.get(url).then(response => {
             this.documents = response.data
            // console.log(this.documents[2].user[0].fullName)
            });
         },
          modalDelete: function() {
            if(Object.keys(this.checked).length != 0) { 
             this.$refs.modalDelete.open()
             // this.docSelected= item
           }
          },
          deleteFiles: function() {
            // si this.checked no esta vacio ejecuta la funcion de borra multiple
            if(Object.keys(this.checked).length != 0) {
               var url ='/files/delete-multiple';
               axios.put(url,{
                 checkedFiles :  this.checked,
                  }).then(response => {
                    this.$refs.modalDelete.close()
                    this.checked = [];
                    this.getAllFiles();
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
@import '../../../../../sass/app.scss'
</style>