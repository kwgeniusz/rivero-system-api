<template>
    <div class="row">
      <sweet-modal ref="modalNew" @close="cancf">

        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Busqueda Avanzada</h4></div>

        <div class="panel-body">
            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
            </ul>
        </div>

        <form  class="form" role="form" @submit.prevent="executeSearch()">

          <div class="form-group col-xs-12 col-md-6">
               <label style="color:red">*</label> <label for="formDatePaid">DESDE:</label>
             <flat-pickr v-model="searcher.date1" :config="configFlatPickr"  class="form-control" id="formDatePaid"></flat-pickr>
          </div>
          <div class="form-group col-xs-12 col-md-6">
              <label style="color:red">*</label>  <label for="formDatePaid">HASTA:</label>
             <flat-pickr v-model="searcher.date2" :config="configFlatPickr"  class="form-control" id="formDatePaid"></flat-pickr>
          </div> 
           <button type="submit" v-if="showSubmitBtn" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  ENVIAR
           </button>

        </form>
         
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

                configFlatPickr:{
                    //  enableTime: true,
                    //  time_24hr: false,
                     altFormat: 'm/d/Y',
                     altInput: true,
                     dateFormat: 'Y-m-d',
                     locale: Spanish, // locale for this instance only  
                 },
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
            executeSearch(){
              this.errors = [];
             
                if (!this.searcher.date1 || !this.searcher.date2 ) 
                this.errors.push('Debe ingresar las dos fechas.');

           if (!this.errors.length) { 
                    this.showSubmitBtn = false;
                    
                    axios.post(`/transactions/${this.sign}/search-between-dates`, this.searcher).then((response) => {
                             this.$emit("filteredTransactions", response.data,this.searcher);
                             this.$emit('close');
                            this.$refs.modalNew.close()
                        })
                    .catch((error) => {
                      this.errors.push(error.response.data.message);
                      this.showSubmitBtn = true;
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