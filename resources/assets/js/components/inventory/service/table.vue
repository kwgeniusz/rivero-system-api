<template>
<div>

    <div class="col-xs-4">
     
    </div>   

    <div class="col-xs-4">
      <ul class="list-group">
        <li class="list-group-item">
            <input type="text" placeholder="Buscar" class="form-control" v-model="inputSearch">
        </li>
       </ul>
    </div> 

   <div class="col-xs-4">
       <div class="btn-group"> 
         <div class="dropdown">
          <button  class="btn btn-info btn-sm" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="#" @click="showModal=true"> Busqueda Avanzada</a></li>
          </ul>
        </div>
    </div>

       <div  class="btn-group"> 
        <div v-if="!loading" class="dropdown">
         <button  class="btn btn-warning btn-sm dropdown-toggle" id="drop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Exportar<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="drop2">
            <li><a href="#" @click="printPDF()"> PDF</a></li>
            <!-- <li><a href="#"> EXCEL</a></li> -->
          </ul>
      </div>  
       <div v-else>
         <loading/><br>
           DESCARGANDO...
      </div>
     </div>  

   </div>

 <br>
      <div class="col-xs-offset-1 col-xs-9">
                <div class="panel panel-default">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="bg-success">
                              <tr>
                                 <th>#</th>
                                 <th>CODIGO</th>
                                 <th>SERVICIO</th>
                                 <th>UNIDAD</th>
                                 <th>COSTO</th>
                                 <th>ACCIONES</th>
                              </tr>
                            </thead>
                            <tbody v-if="searchData.length > 0">
                             <tr v-for="(service, index) in searchData" :key="service.serviceId">
                                <td>{{index + 1}}</td>
                                <td> {{service.serviceCode}}</td>
                                <td> {{service.serviceName}}</td>
                                <td class="text-left"> {{service.unit}} <br>
                                <td class="text-left"> {{service.cost}} </td>
                                <td> 
                                   <button @click="editService(index,service.serviceId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                   <button @click="deleteService(index,service.serviceId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                </td>
                             </tr>
                           </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="12">
                                <loading></loading>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                    </div>
                </div>

            </div>
            </div>
       
</template>

<script>
  import draggable from 'vuedraggable'
  
    export default {
    mounted() {
            console.log('Component service mounted.') 
        },
    data() {
            return{
                inputSearch: '',
            
                showModal: false,
                mutaService: this.serviceList,
                loading: false,
          
            }
        },
      props: {
        serviceList:  {  type: [Array], default: null},
        }, 
        components: {
            draggable,
        }, 
      watch:{
         serviceList: function serviceList(data) {
            this.mutaService = data;
         }
       } ,       
      computed: {
            searchData: function () {
                return this.mutaService.filter((service) => {
                  return service.serviceName.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                })
            }, 
        },
        methods: {
          editService(index, id){
                this.$emit('editData', id)
            },
          deleteService(index, id){
                if (confirm(`Esta seguro de eliminar el Servicio #${++index}?`) ){
                    axios.delete(`/services/${id}`).then((response) => {
                           toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                    })
                }    
            }, 
          printPDF(){
            this.loading = true;

           axios.post('/reports/services',{services: this.mutaService},{
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
                  link.setAttribute('download', 'services.pdf'); //or any other extension
                  document.body.appendChild(link);
                  link.click();
            }).catch((error)=>{
                  alert(error)
                  this.loading = false; 
            })
         }  //end of printPDF 
      }//end of methods
    }

</script>