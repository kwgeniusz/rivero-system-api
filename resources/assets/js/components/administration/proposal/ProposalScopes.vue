
<template> 
  <form class="input-label boxes2" style="margin-bottom: 30px;">
    <div class="col-xs-12  alert alert-danger " v-if="errors.length">
      <h4>Errores:</h4>
      <div v-for="error in errors">- {{ error }}</div>
    </div>
      <label for="scopeDescription">ALCANCE </label>
      <textarea v-model="scopeDescription" class="form-control" id="scopeDescription" name="scopeDescription" rows="3" ></textarea>
<!--             <select v-model="scopeDescription"  @change="selectNote(scopeDescription)" class="form-control" name="noteId" id="noteId">
          <option v-for="(item,index) in notes" :value="item.noteId" > {{item.noteName}}</option>
      </select> -->
      <button class="submit" @click.prevent="addRow()"> 
        <span class="fa fa-plus" aria-hidden="true"></span> Agregar Alcance
      </button>
      <div style="word-wrap: break-word;">
        <h4><b>Alcances de la Propuesta</b></h4>
          <ul>
          <li v-for="(propScope,index) in scopesList">

          <textarea v-if="editMode === index" class="form-control" rows="2" v-model="propScope.description" ></textarea>
          <!-- <input v-if="editMode === index" type="number" step=".00" class="form-control" v-model="item.quantity" @keyup="calculateItemAmount(index,item)"> -->
          <span v-else v-html="nl2br(propScope.description,false) "></span>
          <br>
            <a v-if="editMode === index" @click="updateItemList()" class="supc">
              <i class="glyphicon glyphicon-ok"></i>
            </a> 
            <a v-else @click="editItemList(index)" class="edit" title="Editar" > 
                <i class="fa fa-edit"></i>
            </a> 
            <a @click="deleteScope(++index)" class="supr" data-toggle="tooltip" data-placement="top" title="Eliminar">
              <span class="fa fa-times-circle" aria-hidden="true"></span> 
          </a>
          </li>
        </ul>
      </div>


  </form>    
 </template>



 <script>
// import vueUpload from './vueUpload.vue'

export default {

     mounted() {
            console.log('Component ProposalScope mounted.')
            this.getProposalScopes();
        },
    data: function() {
        return {
            errors: [],
            scopeDescription: '',
          
            scopesList:{},
            // modelNoteName: '',
            editMode: -1,

        }
    },
  props: {
           proposalId: { type: Number},
    },
    methods: {
          getProposalScopes: function (){
            let url ='proposals/'+this.proposalId+'/scopes';

            axios.get(url).then(response => {
             this.scopesList = response.data
            });
        },

  /*----CRUD----- */
        addRow: function() {
           this.errors = [];
           //VALIDATIONS
               if (!this.scopeDescription) 
                this.errors.push('Debe Escribir un Alcance.');
            
            console.log(this.scopeDescription)
          if (!this.errors.length) {
                 this.scopesList.push({
                                     description:this.scopeDescription,
                                   });
           }
               this.scopeDescription = '';

         },
      editItemList: function(index){
             this.editMode = index
        },
      updateItemList: function(){
              this.editMode = -1
            },
        deleteScope: function(id) {
                 this.scopesList.splice(--id,1);
          },
        sendScopes: function() {
            axios.post('proposals/'+this.proposalId+'/scopes',{
              scopesList:   this.scopesList,
            }).then(response => {
                       this.getProposalScopes();
                       this.scopeDescription = '';
                       if (response.data.alertType == 'success') {
                         toastr.success(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }
            })
           
      },
      nl2br: function(str, is_xhtml) {
         if (typeof str === 'undefined' || str === null) {
               return '';
          }
       var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
       return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
     },

    }
       // this.$forceUpdate()
  }
 </script>
  