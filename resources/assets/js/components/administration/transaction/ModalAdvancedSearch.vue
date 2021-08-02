<template>
    <div class="row">
      <sweet-modal ref="modalNew" @close="cancf">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Busqueda Avanzada</h4></div>

        <div class="panel-body" v-if="!loading">
            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
            </ul>
           </div>

        <form  class="form" role="form" @submit.prevent="executeSearch()">

         <div class="form-group col-lg-offset-3 col-lg-7">
            <label for="searchMode">MODO:</label>
            <select class="form-control" id="searchMode" v-model="searchMode">
               <option value="byYear">Por Año</option>
               <option value="byRange">Por Rango de Fecha</option>
            </select>
          </div>  

           <div class="form-group col-lg-offset-3 col-lg-7" v-if="searchMode == 'byYear'">
            <label for="year">AÑO</label>
            <select class="form-control" id="year" v-model="searcher.year">
               <option v-for="year in years" :value="year" :key="year">{{ year }}</option>
            </select>
          </div>  

          <div class="form-group col-xs-12 col-md-6" v-if="searchMode == 'byRange'">
               <label style="color:red">*</label> <label for="formDatePaid">DESDE:</label>
             <flat-pickr v-model="searcher.date1" :config="configFlatPickr"  class="form-control" id="formDatePaid"></flat-pickr>
          </div>
          <div class="form-group col-xs-12 col-md-6" v-if="searchMode == 'byRange'">
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
                searchMode:'byYear', 
                searcher:  {                    
                     date1: '',
                     date2: '',
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
        executeSearch(){
              this.errors = [];
            
             if(this.searchMode == 'byRange'){
                if (!this.searcher.date1 || !this.searcher.date2 ) 
                this.errors.push('Debe ingresar las dos fechas.');
             }
             if(this.searchMode == 'byYear'){
               if (!this.searcher.year) 
                this.errors.push('Debe escoger un Año.');
             }

           if (!this.errors.length) { 
                    this.loading = true;
                    this.showSubmitBtn = false;
                    let url =''; 
                    
                if(this.searchMode == 'byRange'){
                  url = `/transactions/${this.sign}/search-between-dates`;
                }else{
                  url = `/transactions/${this.sign}/search-by-year`;
                }
                    axios.post(url, this.searcher).then((response) => {
                             this.$emit("filteredTransactions", response.data,this.searcher);
                             this.$emit('close');
                             this.$refs.modalNew.close()
                        }).catch((error) => {
                       this.errors.push(error.response.data.message);
                       this.showSubmitBtn = true;
                       this.loading = false;
                       });
              }  //end if error.length 
            },
            cancf(n){
                this.$emit('showlist', 0)
                this.$emit('close') 
            },
        }
    }

</script>