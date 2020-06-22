
<template> 
    <form class="formScope2">
<hr>
     <div class="col-xs-12  alert alert-danger " v-if="errors.length">
            <h4>Errores:</h4>
                  <div v-for="error in errors">- {{ error }}</div>
      </div>

          <div class="form-group col-xs-10 col-xs-offset-1">
            <label for="scopeDescription">ALCANCE </label>
             <textarea v-model="scopeDescription" class="form-control" id="scopeDescription" name="scopeDescription" rows="3" ></textarea>
<!--             <select v-model="scopeDescription"  @change="selectNote(scopeDescription)" class="form-control" name="noteId" id="noteId">
                <option v-for="(item,index) in notes" :value="item.noteId" > {{item.noteName}}</option>
            </select> -->
          </div>


    <div class="row">
       <div class="text-right col-xs-7">
         <button class="btn btn-primary" @click.prevent="addRow()"> 
          <span class="fa fa-plus" aria-hidden="true"></span> Agregar Alcance
         </button>
       </div>
    </div>

    <div class="col-xs-12 text-left" style="word-wrap: break-word;">
          <h4><b>Alcances del Trabajo</b></h4>
           <ul>
            <li v-for="(propScope,index) in scopesList">
              {{ propScope.description }}
              <a @click="deleteScope(++index)" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar">
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
            console.log('Component invoiceScope mounted.')
            this.getInvoiceScopes();
        },
    data: function() {
        return {
            errors: [],
            scopeDescription: '',
          
            scopesList:{},
            // modelNoteName: '',
        }
    },
  props: {
           invoiceId: { type: Number},
    },
    methods: {
          getInvoiceScopes: function (){
            let url ='invoicesScopes/'+this.invoiceId;

            axios.get(url).then(response => {
             this.scopesList = response.data
            });
        },

  /*----CRUD----- */
        addRow: function() {
           this.errors = [];
           //VALIDATIONS
               if (!this.scopeDescription) 
                this.errors.push('Debe Escoger una .');
            
            console.log(this.scopeDescription)
          if (!this.errors.length) {
                 this.scopesList.push({
                                     description:this.scopeDescription,
                                   });
           }

              this.scopeDescription = '';
         },
        deleteScope: function(id) {
                 this.scopesList.splice(--id,1);
          },
        sendScopes: function() {
            axios.post('invoicesScopes',{
              invoiceId :  this.invoiceId,
              scopesList:   this.scopesList,
            }).then(response => {
                       this.getInvoiceScopes();
                       this.scopeDescription = '';
                       if (response.data.alertType == 'success') {
                         toastr.success(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }
            })
           
      },


    }
       // this.$forceUpdate()
  }
 </script>
  