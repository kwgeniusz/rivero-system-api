
<template> 
 <div class="panel panel-success col-xs-10 col-xs-offset-1 col-lg-8 col-lg-offset-2">
    <div class="panel-body">
    <form class="form">

       <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
                  <div v-for="error in errors"> - {{ error }}</div>
        </div>
       
          <div class="form-group col-xs-12">
                <label for="templateName">NOMBRE DE LA PLANTILLA:</label>
                <input v-model="templateName" type="text" class="form-control">
          </div>

           <div class="form-group col-xs-8">
            <label for="serviceId">SERVICIOS:</label>
            <select v-model="modelServiceId" class="form-control" name="serviceId" id="serviceId">
                <option :class="{ bold: item.hasCost == 'Y' ? true : false }" v-for="(item,index) in services" :value="item.serviceId" > {{item.serviceName}}
                 </option>
                  }
            </select>
            <form-new-service pref-url='../' @servicecreated='getAllServices()'></form-new-service>
          </div>


       <div class="form-group col-xs-12 text-center">
         <button class="btn btn-success" @click.prevent="addRow()"> 
          <span class="fa fa-plus" aria-hidden="true"></span> Agregar Renglon
        </button>
       </div>
    </form>

      <br>

      <div class="table-responsive col-xs-12">
          <table class="table table-striped table-bordered text-center bg-info">
            <thead> 
            <tr>  
                <th>#</th>
                <th>SERVICIO</th>  
                <th colspan="1" >ACCION</th>
            </tr>
            </thead>
          <tbody>   
         <tr v-for="(item,index) in itemList">
            <td>{{++index}}</td>
            <td>{{item.serviceName}}</td>
            <td>  
             <a @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
            <button class="btn btn-info btn-sm" @click.prevent="moveUp(index)"> 
              <span class="fa fa-angle-double-up" aria-hidden="true"></span>
             </button>
            <button class="btn btn-info btn-sm" @click.prevent="moveDown(index)">
              <span class="fa fa-angle-double-down" aria-hidden="true"></span>
             </button>
           </td> 
         </tr>
         </tbody>
        </table>
      </div>


    <div class="form-group col-xs-12 text-center">
           <a href="./" class="btn btn-warning btn-sm">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  Regresar
          </a>      
          <a @click.prevent="saveTemplate()" class="btn btn-info btn-sm">
                  <span class="fa fa-save" aria-hidden="true"></span>  Guardar Plantilla
          </a>
            <a @click.prevent="itemList = []"  class="btn btn-danger btn-sm">
                  <span class="fa fa-recycle" aria-hidden="true"></span>  Vaciar
          </a>
    </div>


   </div>

    {{modelServiceId}}
    {{itemList}}

     // {{services}}

  </div>

</div>

 </template>

<script>
export default {
        
     mounted() {
            console.log('Component mounted ServiceTemplates.')
               this.getAllServices();
        },
    data: function() {
        return {
            errors: [],

            templateName: '',//input nombre de la plantilla
            modelServiceId: '', //input de select de servicios
            itemList: [], //arreglo para los articulos
            
            services: {},//me los traigo de una peticion ajax
            hasCost: false,
        }
    },
  props: {
     
    },
  computed: {
      sumTotal: function () {
          let sum = this.modelQuantity * this.modelUnitCost;
          return  Number.parseFloat(sum).toFixed(2);
       } 
    },
      methods: {
         getAllServices: function (){
            let url ='../services';
            axios.get(url).then(response => {
             this.services = response.data
            });
        },
  /* ----CRUD----- */
        addRow: function() {
           this.errors = [];
           //VALIDATIONS
               if (!this.modelServiceId) 
                this.errors.push('Debe Escoger un Servicio.');
           
          if (!this.errors.length) {
      //BUSCAR EN ARREGLO DE JAVASCRIPT /SERVICE/ EL ID QUE SELECCIONO EL USUARIO PARA TRAER EL NOMBRE DEL SERVICIO
        let serviceId = this.modelServiceId;
    
        function filtrarPorID(obj) {
          if ('serviceId' in obj && obj.serviceId == serviceId) {
            return true;
          } else {
            return false;
          }
        }
        let serviceSelected = this.services.filter(filtrarPorID);

            //AGREGAR A ITEMLIST
              //Nota al agregar el item debo meter un objeto con el nombre y el ID
                 this.itemList.push({serviceId:serviceSelected[0].serviceId,serviceName:serviceSelected[0].serviceName});

           }
          },
          deleteRow: function(id) {
            //borrar valor que encuentre del arreglo
                 this.itemList.splice(--id,1);
          },
         moveUp: function(rowIndex) {
             --rowIndex;
             this.itemList.splice(rowIndex - 1, 0, this.itemList.splice(rowIndex, 1)[0]);
           },
         moveDown: function(rowIndex) {
            --rowIndex;
             this.itemList.splice(rowIndex + 1, 0, this.itemList.splice(rowIndex, 1)[0]);
           },
        saveTemplate: function(id) {
            this.errors = [];
           //VALIDATIONS
               if (!this.templateName) 
                this.errors.push('Debe Ingresar un Nombre para la Plantilla.');
               if (this.itemList.length == 0) 
                this.errors.push('Debe Tener articulos en la lista.');
           
          if (!this.errors.length) {
            axios.post('invoicesDetails',{
              servicesTemplate :  this.itemList,
            }).then(response => {
                   // if (response.data.alert == "error") {
                   //     toastr.error(response.data.msj)
                   // } else {
                       this.templateName = ''
                       this.itemList = []
                       this.modelServiceId =''

                       if (response.data.alertType == 'success') {
                         toastr.success(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }
                   // }
  
            }) //fin de axios

            }
          },

    }
       // this.$forceUpdate()
}
 </script>
  
<style>
.bold {
    font-weight:bold;
    background:#D7F7E2;
}
</style>