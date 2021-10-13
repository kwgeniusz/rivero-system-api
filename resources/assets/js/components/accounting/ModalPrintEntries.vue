<template>
    <div class="row">
      <sweet-modal ref="modalNew" @close="cancf">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Imprimir Reporte - Asientos Contables</h4></div>

        <div class="panel-body" v-if="!loading">
            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
            </ul>
           </div>

        <form  class="form" role="form" @submit.prevent="printPDF()">

         <div class="form-group col-lg-offset-3 col-lg-7">
            <label for="modelReport">MODELO:</label>
            <select class="form-control" id="modelReport" v-model="modelReport">
               <option value="accountCode">Codigo de Cuenta</option>
               <option value="accountName">Nombre de Cuenta</option>
            </select>
          </div>  

          <div class="form-group col-xs-12 col-md-6">
               <label style="color:red">*</label> <label for="formDatePaid">DESDE:</label>
             <flat-pickr v-model="searcher.date1" :config="configFlatPickr"  class="form-control" id="formDatePaid"></flat-pickr>
          </div>
          <div class="form-group col-xs-12 col-md-6">
              <label style="color:red">*</label>  <label for="formDatePaid">HASTA:</label>
             <flat-pickr v-model="searcher.date2" :config="configFlatPickr"  class="form-control" id="formDatePaid"></flat-pickr>
          </div> 

           <div class="row"/>
           <button type="submit" v-if="showSubmitBtn" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  ENVIAR
           </button>

        </form>
         
        </div>
         <div v-else>
          <br>
          <loading/><br>
           PROCESANDO...
          <br>
      </div>



    </div>
</div>

   </sweet-modal>     
  </div>
</template>

<script>
    import {Spanish} from 'flatpickr/dist/l10n/es.js';

    export default {
        mounted() {
              this.$refs.modalNew.open()
        },
        data(){
            return{
                errors: [],
                showSubmitBtn:true,
                loading: false,

                configFlatPickr:{
                     altFormat: 'm/d/Y',
                     altInput: true,
                     dateFormat: 'Y-m-d',
                     locale: Spanish, // locale for this instance only  
                 },
                modelReport:'accountName', 
                searcher:  {                    
                     date1: '',
                     date2: '',
                },
            }
         },
      props: {
           sign: { type: String},
      },   
      methods: {
           printPDF(){
            this.errors = [];
                    
                if (!this.searcher.date1 || !this.searcher.date2 ) 
                this.errors.push('Debe ingresar las dos fechas.');

         if (!this.errors.length) { 
             this.loading = true;
           axios.post('/accounting/reports/entries',{modelReport: this.modelReport, dateRange: this.searcher},{
            responseType: 'blob',
            onDownloadProgress: (progressEvent) => {
               console.log(progressEvent.total)
               this.percentCompleted = Math.round((progressEvent.loaded * 100) );
              // console.log(percentCompleted)
              }
             }).then((response) => {
                  this.loading = false; 
                  
                  const url  = window.URL.createObjectURL(new Blob([response.data]));
                  const link = document.createElement('a');
                  link.href = url;
                  link.setAttribute('download', 'Accounting Entries.pdf'); //or any other extension
                  document.body.appendChild(link);
                  link.click();
            }).catch((error)=>{
                  alert(error)
                  this.loading = false; 
            })
           }  //end if error.length  
         },  //end of printPDF   
            cancf(n){
                this.$emit('showlist', 0)
                this.$emit('close') 
            },
        }
    }

</script>