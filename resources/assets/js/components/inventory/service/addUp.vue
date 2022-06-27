<template>
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <div class="panel panel-default">

                <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Servicio</h4></div>
                <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Servicio</h4></div>


        <div class="panel-body">


            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
               <ul>
                 <li v-for="(error,index) in errors"  :key="index">{{ error }}</li>
              </ul>
           </div>

        <form class="form" ref="formService" id="formService" role="form" @submit.prevent="createService()">
    
                <div class="form-group col-lg-12 ">
                       <label for="accountTypeCode">CATEGORIA:</label>
                       <v-select :options="serviceList" v-model="service.serviceParentId" :reduce="serviceList => serviceList.serviceId" label="item_data" />
                  </div>  

                <div class="form-group col-md-7">
                          <label for="description" class="form-group">CODIGO:</label>
                         <input placeholder="5.1.2.100" type="text" v-model="service.serviceCode" class="form-control" id="description" name="description" autocomplete="off">
                    </div>


                   <div class="form-group col-md-7">
                          <label for="description" class="form-group">NOMBRE:</label>
                         <input type="text" v-model="service.serviceName" class="form-control" id="description" name="description" autocomplete="off">
                    </div>

                   <div class="form-group col-md-7">
                          <label for="description" class="form-group">UNIDAD:</label>
                         <input type="text" v-model="service.unit" class="form-control" id="description" name="description" autocomplete="off">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="amount" class="form-group">COSTO:</label>
                         <input type="number" class="form-control" step="0.01" id="amount" name="amount"  v-model="service.cost" autocomplete="off">
                   </div>  


                        <div v-if="editId === 0">
                             <button-form 
                              :buttonType = 1
                               @cancf = "cancf"
                                v-if="showSubmitBtn"
                             ></button-form>

                            </div>

                            <div v-if="editId > 0">
                                <button-form 
                                    :buttonType = 2
                                    @cancf = "cancf"
                                ></button-form>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
 

    export default {
        mounted() {
         console.log('Service Component mounted');

            axios.get('/services').then(response => {
                this.serviceList = response.data;
                this.serviceList.map(function (x){ return x.item_data = `${x.serviceCode} - (${x.serviceName})` });
               // console.log(this.serviceList)
            })

            if (this.editId > 0) {
                // service to edit.
                axios.get(`/services/${this.editId}`).then((response) => {
                    let data = response.data[0]

                    this.service.serviceParentId = data.serviceParentId;
                    this.service.serviceCode = data.serviceCode;
                    this.service.serviceName     = data.serviceName;
                    this.service.unit     = data.unit;
                    this.service.cost     = data.cost;
                });
            }
        },
        data(){
            return{
                errors: [],
                serviceList: [],
                showSubmitBtn:true,

                service:  {
                     serviceParentId: '',
                     serviceCode: '',
                     serviceName: '',
                     unit: '',
                     cost: 0,
                },
            }
         },
       props: {
            editId:'',
        },
        methods: {
            createService(){
              this.errors = [];

               if (!this.service.serviceName) 
                this.errors.push('Debe escribir un Nombre para el servicio.');
               if (!this.service.serviceCode) 
                this.errors.push('Debe escribir un Codigo para el servicio.');

           if (!this.errors.length) { 

                 let formData = new FormData();
                     formData.append('serviceParentId',this.service.serviceParentId);
                     formData.append('serviceCode',this.service.serviceCode);
                     formData.append('serviceName',this.service.serviceName);
                     formData.append('unit',this.service.unit);
                     formData.append('cost',this.service.cost);
        
                if (this.editId === 0) {
                     this.showSubmitBtn =false;

                    axios.post('/services', formData)
                    .then((response) => {
                         toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                        })
                    .catch((response) => {
                        alert("Error de Servidor")
                         this.showSubmitBtn =true;
                    });

                }else {
                    formData.append("_method", "put");
                    axios.post(`/services/${this.editId}`, formData)
                    .then((response) => {
                        toastr.success(response.data.message);
                        this.$emit('showlist', 0);
                        })
                    .catch((error) => {
                        console.log(error);
                    });
                }   // else end   
             }  //end if error.length 
            },
            cancf(n){
                console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
            },
    
 
        }
    }

</script>