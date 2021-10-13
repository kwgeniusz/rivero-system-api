<template>
    <div class="row">
      <sweet-modal ref="modalNew" @close="cancf">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Imprimir Reporte - Libro Mayor</h4></div>

        <div class="panel-body" v-if="!loading">
            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
            </ul>
           </div>

        <form  class="form" role="form" @submit.prevent="printPDF()">

          <div class="form-group col-xs-12 col-md-6">
              <label for="year">MES</label>
            <select class="form-control" id="year" v-model="searcher.month">
               <option value="1">Enero</option>
               <option value="2">Febrero</option>
               <option value="3">Marzo</option>
               <option value="4">Abril</option>
               <option value="5">Mayo</option>
               <option value="6">Junio</option>
               <option value="7">Julio</option>
               <option value="8">Agosto</option>
               <option value="9">Septiembre</option>
               <option value="10">Octubre</option>
               <option value="11">Noviembre</option>
               <option value="12">Diciembre</option>
            </select>
          </div>

          <div class="form-group col-xs-12 col-md-6">
             <label for="year">AÑO</label>
            <select class="form-control" id="year" v-model="searcher.year">
               <option v-for="year in years" :value="year" :key="year">{{ year }}</option>
            </select>
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

                searcher:  {                    
                     month: '',
                     year: '',
                },
            }
         },
      props: {
           sign: { type: String},
      },   
     computed : {
       //esta propiedad computada es para el select con a#os que se generan dinamicamente.) (linea 19-25)
       years () {
        const year = new Date().getFullYear()
        return Array.from({length: year - 2019}, (value, index) => 2020 + index)
       }
     } ,   
      methods: {
           printPDF(){
            this.errors = [];
            // this.showSubmitBtn = false;
                    
                if (!this.searcher.month || !this.searcher.year ) 
                this.errors.push('Debe ingresar las dos fechas.');

         if (!this.errors.length) { 
             this.loading = true;
           axios.post('/accounting/reports/general-ledger',{dates: this.searcher},{
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
                  link.setAttribute('download', 'General Ledger.pdf'); //or any other extension
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