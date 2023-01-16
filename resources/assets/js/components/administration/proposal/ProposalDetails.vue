<template> 
  <div class="create" v-if="proposal != ''">
    <div class="formulario">
      <div class="boxes">
        <div class="inputother boxes2">
          <h4><b>Propuesta N°:</b> {{proposal[0].propId}}</h4>
          <h4><b>Fecha:</b> {{proposal[0].proposalDate | moment("MM/DD/YYYY hh:mm A") }}</h4>
          <h4><b>Vendedor:</b> {{proposal[0].user.fullName }}</h4>
          <a :href="'reportsProposal?id='+proposal[0].proposalId" class="submit" style="width: 100%; text-align: center;" data-toggle="tooltip" data-placement="top" title="Imprimir">
            <span class="fa fa-file-pdf" aria-hidden="true"></span> Previzualizar Propuesta
          </a>
        </div>

        <proposal-subcontractor :proposal="proposal[0]" ref="proposalSubcontractor"/>
        <proposal-scopes :proposal-id="proposal[0].proposalId" ref="proposalScopes"/>
        
        <form class="input-label" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
          <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
            <div v-for="error in errors">- {{ error }}</div>
          </div>


       <!-- <recursive-select :choices="serviceCategories" @sendCategory="categorySelected"/> -->

                <!-- {{serviceCategories}} -->
        
          <div class="input-label boxes2">
            <label for="serviceId">CATEGORIA</label>
            <v-select @input="getSubcategory()" 
            v-model="categorySelected" 
            :options="serviceCategories" 
            :reduce="serviceCategories => serviceCategories" label="item_data"/>
          </div>

        <div class="input-label boxes2" v-if="subcategorySelected1">
            <label for="serviceId">SUB-CATEGORIA 1</label>
            <v-select @input="getSubcategory2()" 
            v-model="subcategorySelected1" 
            :options="listSubcategory" 
            :reduce="listSubcategory => listSubcategory" label="item_data"/>
          </div>


         <div class="input-label boxes2" v-if="subcategorySelected2">
            <label for="serviceId">SUBCATEGORIA 2</label>
            <v-select @input="filterServicesList()" 
            v-model="subcategorySelected2" 
            :options="listSubcategory2" 
            :reduce="listSubcategory2 => listSubcategory2" label="item_data"/>
          </div>
          
          <div class="input-label boxes2" >
            <label for="serviceId">SERVICIO</label>
            <v-select @input="pasteServiceInfo()" 
            v-model="selectedService" 
            :options="servicesFiltered" 
            :reduce="servicesFiltered => servicesFiltered" label="item_data"/>
          </div>


          <div v-if="selectedService" class="inputother boxes2">
            <label for="unit">UNIDAD</label>
            <select v-model="modelUnit" @change="changeUnit(modelUnit)"  class="form-control" name="unit" id="unit">
                <option value="sqft">sqft</option>
                <option value="ea">ea</option>
            </select>
          </div>
          <div v-if="selectedService" class="inputother boxes2">
            <label for="unitCost">PRECIO</label>
            <input v-model="modelUnitCost" type="number" class="form-control" id="unitCost" name="unitCost" autocomplete="off">
          </div>
          <div v-if="selectedService" class="inputother boxes2">
            <label for="quantity">CANTIDAD</label>
            <input v-model="modelQuantity" type="number" class="form-control" id="quantity" name="quantity"  autocomplete="off">
          </div>
          <div v-if="selectedService" class="inputother boxes2">
            <label> COSTO TOTAL: {{sumTotal}}</label>
          </div>
          <div style="width: 100%; display: flex; justify-content: center; align-items: flex-start;">
            <button class="submit buttonmovil" @click.prevent="addRow()" style="margin-right: 20px;"> 
              <span class="fa fa-plus" aria-hidden="true"></span> Agregar Renglon
            </button>
            <!-- <form-new-service pref-url='' @servicecreated='getAllServices()'></form-new-service> -->
          </div>
        </form>

<!-- <recursive-table/> -->
<!-- <tree-table
          class="table"
          :columns="columns"
          :table-data="tableData" /> -->

  <div class="table-responsive col-xs-12">
          <table class="table table-bordered">
            <thead class="bg-primary"> 
            <tr>  
                <th>#</th>
                <th>CODIGO</th>
                <th>SERVICIO</th>  
                <th>UNIDAD</th>
                <th>CANTIDAD</th>
                <th>U.P</th>
                <th>MONTO</th>
                <th colspan="2" >ACCION</th>
            </tr>
            </thead>
          <tbody>   
           <template v-for="(category,categoryIndex) in itemList">      
               <tr class="bg-info">
                 <td>{{++categoryIndex}}</td>
                 <td>{{category.accountCode}}</td>
                 <td>{{category.categoryName}}</td>
                 <td>
                     <select v-if="editModeCategory === categoryIndex" class="form-control" v-model="category.unit">
                       <option value="sqft">sqft</option>
                       <option value="ea">ea</option>
                     </select>
                     <p v-else>{{category.unit}}</p> 
                </td>
                <td>
                  <input v-if="editModeCategory === categoryIndex" type="number" step=".00" class="form-control" v-model="category.quantity" @keyup="calculateItemAmount(categoryIndex,category)">
                  <p v-else>{{category.quantity}}</p> 
                </td>
                <td>
                  <input v-if="editModeCategory === categoryIndex" type="number" step=".00" class="form-control" v-model="category.unitCost" @keyup="calculateItemAmount(categoryIndex,category)">
                  <p v-else>{{category.unitCost}}</p> 
               </td>
                <td> {{category.amount}}</td>
                <td>
                   <a v-if="editModeCategory === -1" @click="editItemList(categoryIndex, category)" class="btn btn-sm btn-primary" title="Editar" > 
                     <i class="fa fa-edit"></i>
                   </a>   
                   <a v-if="editModeCategory === categoryIndex" @click="updateItemList(category)" class="btn btn-sm btn-success">
                     <i class="glyphicon glyphicon-ok"></i>
                   </a> 
                   <a v-if="category.categoryId" @click="deleteRow(categoryIndex,'',category)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                 <span class="fa fa-times-circle" aria-hidden="true"></span> 
                   </a>
                    <!-- <button class="btn btn-info btn-sm" @click.prevent="moveUp(categoryIndex)"> 
                      <span class="fa fa-angle-double-up" aria-hidden="true"></span>
                   </button>
                   <button class="btn btn-info btn-sm" @click.prevent="moveDown(categoryIndex)">
                     <span class="fa fa-angle-double-down" aria-hidden="true"></span>
                   </button> -->
              </td> 
              </tr>
                 <tr v-for="(service,serviceIndex) in category.childrens">
                  <td>{{categoryIndex}}.{{++serviceIndex}}</td>
                  <td>{{service.accountCode}}</td>
                  <td>{{service.serviceName}}</td>
                  <td>{{service.unit}}</td>
                  <td>
                    <input v-if="editModeService === serviceIndex" type="number" step=".00" class="form-control" v-model="service.quantity" @keyup="calculateItemAmount(serviceIndex,service)">
                    <p v-else>{{service.quantity}}</p> 
                 </td>
                 <td>
                    <input v-if="editModeService === serviceIndex" type="number" step=".00" class="form-control" v-model="service.unitCost" @keyup="calculateItemAmount(serviceIndex,service)">
                    <p v-else>{{service.unitCost}}</p> 
                </td>
                 <td> {{service.amount}}</td>
                 <td>
                   <a v-if="editModeService === -1" @click="editItemList(serviceIndex, service)" class="btn btn-sm btn-primary" title="Editar" > 
                     <i class="fa fa-edit"></i>
                   </a>   
                   <a v-if="editModeService === serviceIndex" @click="updateItemList(service)" class="btn btn-sm btn-success">
                     <i class="glyphicon glyphicon-ok"></i>
                   </a> 
                   <a v-if="service.serviceId" @click="deleteRow(categoryIndex, serviceIndex, service)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                 <span class="fa fa-times-circle" aria-hidden="true"></span> 
                   </a>
                    <!-- <button class="btn btn-info btn-sm" @click.prevent="moveUp(serviceIndex)"> 
                      <span class="fa fa-angle-double-up" aria-hidden="true"></span>
                   </button>
                   <button class="btn btn-info btn-sm" @click.prevent="moveDown(serviceIndex)">
                     <span class="fa fa-angle-double-down" aria-hidden="true"></span>
                   </button> -->
              </td> 
                </tr> 

           </template>
         </tbody>   
        </table>
       </div>
          
        <!-- <div class="table-responsive tableother">
            <table class="table table-striped table-bordered bg-info">
              <thead class="text-center "> 
              <tr>  
                  <th>#</th>
                  <th>NUMBER</th>  
                  <th>SERVICIO</th>  
                  <th>UNIDAD</th>
                  <th>U.P</th>
                  <th>CANTIDAD</th>
                  <th>MONTO</th>
                  <th colspan="2" >ACCION</th>
              </tr>
              </thead>
            <tbody>   
          <tr v-for="(item,index) in itemList">
              <td>{{++index}}</td>
              <td text-align="left">{{item.accountCode}}</td>
              <td>{{item.serviceName}}</td>
              <td>
                <select v-if="editMode === index" class="form-control" v-model="item.unit">
                  <option value="sqft">sqft</option>
                  <option value="ea">ea</option>
                </select>
                <p v-else>{{item.unit}}</p> 
              </td>
              <td>
                <input v-if="editMode === index" type="number" step=".00" class="form-control" v-model="item.quantity" @keyup="calculateItemAmount(index,item)">
                <p v-else>{{item.quantity}}</p> 
              </td>
              <td>
                <input v-if="editMode === index" type="number" step=".00" class="form-control" v-model="item.unitCost" @keyup="calculateItemAmount(index,item)">
                <p v-else>{{item.unitCost}}</p> 
              </td>
              <td> {{item.amount}}</td>
              <td>
                <a @click="editItemList(index)" class="btn btn-sm btn-primary" title="Editar" > 
                  <i class="fa fa-edit"></i>
                </a>   
                <a v-if="editMode === index" @click="updateItemList()" class="btn btn-sm btn-success">
                  <i class="glyphicon glyphicon-ok"></i>
                </a> 
                <a v-if="item.serviceId" @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
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
        </div> -->
        
        <div style="text-align: center; width: 100%; margin: auto;">
              {{proposalNetTotal}}
        </div>
        <proposal-times :proposal-id="proposal[0].proposalId" ref="proposalTimes"/>
        <proposal-terms :proposal-id="proposal[0].proposalId" ref="proposalTerms"/>
        <proposal-notes :proposal-id="proposal[0].proposalId" ref="proposalNotes"/>
      </div>
    </div>
    <div class="botonera"> 
      <a @click.prevent="saveProposal()" class="submit buttonmovil">
        <span class="fa fa-save" aria-hidden="true"></span>  Guardar Propuesta
      </a>
      <a @click.prevent="itemList = []"  class="submit buttonmovil" style="margin-left: 20px; background: #d60101;">
        <span class="fa fa-recycle" aria-hidden="true"></span>  Vaciar
      </a>
      <a v-if="proposal[0].netTotal > 0" :href="'proposalsPayments/'+proposal[0].proposalId+'?btnReturn=mod_cont'" class="submit buttonmovil" style="margin-left: 20px; background: green;" data-toggle="tooltip" data-placement="top" title="Cuotas">
        <span class="fa fa-dollar-sign" aria-hidden="true"></span> Cuotas
      </a>
    </div>
  </div>

</template>
 <script>

// import TreeTable from 'vue-tree-table-component'
import proposalScopes from './ProposalScopes.vue'
import proposalTimes from './ProposalTimes.vue'
import proposalTerms from './ProposalTerms.vue'
import proposalNotes from './ProposalNotes.vue'
import proposalSubcontractor from './ProposalSubcontractor.vue'

export default {
        
     mounted() {
            console.log('Component mounted.')
            this.getAllServiceCategories();
            this.getAllServices();
            this.findProposal();
            this.getAllProposalDetails();
        },
   components: {
         proposalScopes,
         proposalTimes,
         proposalTerms,
         proposalNotes,
         proposalSubcontractor

  },     
    data: function() {
        return {
            errors: [],

            servicecategories: [],

            categorySelected:[],
            listSubcategory:[],
            subcategorySelected1:[],
            listSubcategory2:[],
            subcategorySelected2:[],
            servicesFiltered:[],

            services: [],
            proposal: '',
            selectedService: '',
            itemList: [],
            
            //variables del formulario
            modelServiceId: '',
            modelQuantity: '',
            modelUnit: '',
            modelUnitCost: '',

            editModeCategory: -1,
            editModeService: -1,
        }
    },
  props: {
           proposalId: { type: String},
    },
  // components: {TreeTable},
  computed: {
      sumTotal: function () {
          let sum = this.modelQuantity * this.modelUnitCost;
          return  Number.parseFloat(sum).toFixed(2);
       },
      proposalNetTotal: function () {
          let suma = 0;

         this.itemList.forEach (function(item){
              // console.log(item)
              suma += parseFloat(item.amount);
              suma.toFixed(2);
          });
  
              let taxAmount   = (parseFloat(suma).toFixed(2) * parseFloat(this.proposal[0].taxPercent).toFixed(2))/100;
              let netTotal    = parseFloat(taxAmount) + parseFloat(suma);

               return (
                `Sub Total: ${suma} /
               Impuesto:${this.proposal[0].taxPercent}% = ${taxAmount} /
               Total Neto: ${netTotal}
               ` )
       } 
    },
    methods: {
       getAllServiceCategories: function (){
         let url ='service-categories';
         axios.get(url).then(response => {
                   this.serviceCategories = response.data
                   this.serviceCategories.map(function (x){ return x.item_data = `${x.accountCode} - (${x.categoryName})` });
         });
     },
      getAllServices: function (){
         let url ='services';
         axios.get(url).then(response => {
          this.services = response.data
          // console.log(this.services)
          this.services.map(function (x){ return x.item_data = `${x.accountCode} - (${x.serviceName})` });

         });
     },
        findProposal: function (){
            let url ='proposals/'+this.proposalId;
            axios.get(url).then(response => {
             this.proposal = response.data
            });
        },
         getAllProposalDetails: function (){
           //inicializa la lista en cero
            this.itemList = []    

            let url ='proposalsDetails/'+this.proposalId;
            axios.get(url).then(response => {

             let servicesArray = response.data
      
            servicesArray.forEach(element => {
      
               // Encontrar si existe la categoria en la propuesta que se esta montando
               let found = this.itemList.find(item => item.categoryId == element.categoryId);

                //  Si existe la categoria, debo insertar el servicio  dentro de esa categoria existente en la propuesta
                   if(!found) {
                     this.itemList.push({ 
                                         categoryId:  element.category.categoryId,
                                         isHeaderTag: 'Y',
                                         accountCode: element.category.accountCode,
                                         categoryName:  element.category.categoryName,
                                         quantity:  element.quantity,
                                         unit:  element.unit,
                                         unitCost:  0,
                                         amount:  0,
                                         childrens: []
                                       });
                      // alert('no se encontro la categoria en el arreglo, crearla');
                  }
                  //acumular saldo de los valores

            //  Buscar el indice de la categoria existente para insertar en servicio en la categoria especifica
              let categoryIndex = this.itemList.findIndex(object => {
                    return object.categoryId === element.category.categoryId;
              });
                  this.itemList[categoryIndex].unitCost += parseFloat(element.unitCost)
                  this.itemList[categoryIndex].amount   += parseFloat(element.amount)
                  
                 this.itemList[categoryIndex].childrens.push({ 
                                     serviceId:  element.serviceId,
                                     isHeaderTag: 'N',
                                     categoryId:  element.categoryId,
                                     accountCode: element.service.accountCode,
                                     serviceName: element.serviceName,
                                     quantity: element.quantity,
                                     unit: element.unit,
                                     unitCost: element.unitCost,
                                     amount: element.amount
                                    });
                     });  //end foreach
                }); //end axion get
               
        },
        pasteServiceInfo: function (){
              if(this.selectedService){ 
                 this.modelQuantity= 1.00
                 this.modelUnit = this.selectedService.unit;
                 this.modelUnitCost = this.selectedService.cost;
              }
        },
         changeUnit: function(unit) {
             if(unit == 'sqft'){
               this.modelUnitCost = this.selectedService[0].cost1;
             }else {
               this.modelUnitCost = this.selectedService[0].cost2;
             }
          },

  /*----CRUD----- */
     addRow: function() {
           this.errors = [];

           //VALIDATIONS
          if (!this.selectedService) 
                this.errors.push('Debe Escoger un Servicio.');
           
          if (!this.errors.length) {
              //Nota al agregar el item debo meter un objeto con el nombre y el 
        
            // Encontrar si existe la categoria en la propuesta que se esta montando
               let found = this.itemList.find(item => item.categoryId == this.selectedService.categoryId);

                //  Si no existe la categoria en la propuesta, se insert
                   if(!found) {
                     this.itemList.push({ 
                                         categoryId: this.selectedService.categories.categoryId,
                                         isHeaderTag: 'Y',
                                         accountCode:this.selectedService.categories.accountCode,
                                         categoryName: this.selectedService.categories.categoryName,
                                         quantity: this.modelQuantity,
                                         unit: this.modelUnit,
                                         unitCost: this.modelUnitCost,
                                         amount: this.sumTotal,
                                         childrens: []
                                       });
                      // alert('no se encontro la categoria en el arreglo, crearla');
                  } 

            //  Buscar el indice de la categoria existente para insertar en servicio en la categoria especifica
              let categoryIndex = this.itemList.findIndex(object => {
                    return object.categoryId === this.selectedService.categories.categoryId;
              });
//  Si existe la categoria, debo insertar el servicio  dentro de esa categoria existente en la propuesta
              this.itemList[categoryIndex].childrens.push({ 
                                     serviceId: this.selectedService.serviceId,
                                     isHeaderTag: 'N',
                                     categoryId: this.selectedService.categoryId,
                                     accountCode:this.selectedService.accountCode,
                                     serviceName:this.selectedService.serviceName,
                                     quantity:this.modelQuantity,
                                     unit:this.modelUnit,
                                     unitCost:this.modelUnitCost,
                                     amount:this.sumTotal
                                    });

              this.selectedService.quantity     = this.modelQuantity,
              this.selectedService.unitSelected = this.modelUnit,
              this.selectedService.unitCost     = this.modelUnitCost,
              this.selectedService.sumTotal     = this.sumTotal
            
          console.log(this.itemList);
          } //end of "if (!this.errors.length)" 
        },
      editItemList: function(index, item){
         //Editar valor que encuentre del arreglo
              if(item.isHeaderTag == 'Y'){
                  this.editModeCategory = index
              }else{
                  this.editModeService = index
              }
        },
      updateItemList: function(item){
             if(item.isHeaderTag == 'Y'){
                  this.editModeCategory = -1
              }else{
                  this.editModeService = -1
              }
        },
         
        deleteRow: function(categoryIndex ='', serviceIndex='',item) {
            //borrar valor que encuentre del arreglo
              if(item.isHeaderTag == 'Y'){
                this.itemList.splice(--categoryIndex,1);
              }else{
                this.itemList[--categoryIndex].childrens.splice(--serviceIndex,1);
              }
          },
         moveUp: function(rowIndex) {
             --rowIndex;
             this.itemList.splice(rowIndex - 1, 0, this.itemList.splice(rowIndex, 1)[0]);
           },
         moveDown: function(rowIndex) {
             --rowIndex;
             this.itemList.splice(rowIndex + 1, 0, this.itemList.splice(rowIndex, 1)[0]);
           },
        calculateItemAmount: function(index,item) { 
          // console.log(index)
          // console.log(item);
          //regla: si no es un numero ponle cero
           if(item.unitCost == '' || item.unitCost == 0) {
              item.unitCost = 1;
          }
           if(item.quantity == '' || item.quantity == 0) {
              item.quantity = 1;
          }

             let amountRs = item.unitCost * item.quantity;
                 item.amount  = parseFloat(amountRs).toFixed(2);


             let unitCostToEachChild =   item.unitCost / item.childrens.length;
             
                   let i, n = item.childrens.length;
                    for (i = 0; i < n; ++i) {
                            item.childrens[i].quantity = item.quantity;
                            item.childrens[i].unitCost = unitCostToEachChild;

                             let amountToEachChild   =   unitCostToEachChild * item.quantity;
                            item.childrens[i].amount = amountToEachChild;
                        }
            
            //  let myObj = this.itemList.find(el => el.categoryId == item.categoryId);
            //      myObj.amount = parseFloat(amountRs).toFixed(2);

          //SI, el item modificado es un servicio, realiza la suma el Header Tag
          
        },     
         saveProposal: function() {
           this.errors = [];
           //VALIDATIONS
               if (!this.itemList) 
                this.errors.push('Debe Escoger Ingresar servicio para Guardar la Propuesta.');
          

          if (!this.errors.length) { 
        //ejecuta la funciona que esta en el componente hijo Proposal Notes
          this.$refs.proposalScopes.sendScopes();
          this.$refs.proposalTimes.sendTimes();
          this.$refs.proposalTerms.sendTerms();
          this.$refs.proposalNotes.sendNotes();

          axios.post('proposalsDetails',{
              proposalId :  this.proposal[0].proposalId,
              itemList:   this.itemList,
            }).then(response => {
                   // if (response.data.alert == "error") {
                   //     toastr.error(response.data.msj)
                   // } else {
                     
                       this.findProposal();
                       this.getAllProposalDetails();

                       this.modelServiceId = ''
                       // this.modelServiceName = ''
                       this.modelQuantity =''
                       this.modelUnit =''
                       this.modelUnitCost =''
                
                       if (response.data.alertType == 'success') {
                         toastr.success(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }
                   // }
  
            })
               }
          }, //end function saveProposal
          getSubcategory(){
            this.listSubcategory = this.categorySelected.children_categories_tree;
            this.listSubcategory.map(function (x){ return x.item_data = `${x.accountCode} - (${x.categoryName})` });
          },
          getSubcategory2(){
            this.listSubcategory2 = this.subcategorySelected1.children_categories_tree;
            this.listSubcategory2.map(function (x){ return x.item_data = `${x.accountCode} - (${x.categoryName})` });
          },  
          filterServicesList(){
            this.subcategorySelected2
            this.servicesFiltered = this.services.filter(service => service.categoryId == this.subcategorySelected2.categoryId)
            this.servicesFiltered.sort((x, y) => x.serviceId - y.serviceId);
          },  
        //  categorySelected(value){
        //    console.log('sendCategory')
        //       console.log(value)
        // },   
    } // fin de vue methods
       
}// fin de export
 </script>
  
<style>

#mySelect .v-select .dropdown-toggle {
   border: 2px red;
}

.bold {
    font-weight:bold;
    background:#D7F7E2;
}
.create {
  position: relative;
  padding: 40px;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  background: #dadada;
  border-radius: 20px;
  flex-wrap: wrap;
  margin: auto;
}

.formulario {
  background: #fff;
  width: 80%;
  padding: 40px;
  border-radius: 20px;
  position: relative;
}
.title {
  font-weight: 400;
  color: rgb(134, 134, 134);
  padding: 20px 0px;
}

.boxes {
  border-top: 2px solid #ccc;
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  flex-wrap: wrap;
  padding-top: 10px;
}
.input-label{
  position: relative;
  max-width: 100%;
  min-width: 100%;
  margin-bottom: 0px;
}
.input {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 0px;
}
.textarea {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 30px;
  display: flex;
  flex-direction: column;
}
.inputother {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 30px;
}
.tableother {
  position: relative;
  max-width: 100%;
  min-width: 100%;
  margin-bottom: 10px;
}
input,
select {
  padding: 10px;
  border-radius: 5px;
  width: 100%;
  border: 1px solid #ccc;
  background: rgba(248, 248, 248, 0.815);
}
textarea {
  max-width: 100%;
  min-width: 100%;
  max-height: 100px;
  min-height: 100px;
}
label {
  margin-bottom: 10px;
}

.boxes2 {
  display: flex;
  flex-direction: column;
}

.submit {
  margin-top: 30px;
  font-size: 1em;
  padding: 10px 20px;
  background: #0062be;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
}
.submit:hover {
  color: #fff;
  text-decoration: none;
}
.return {
  margin-top: 30px;
  font-size: 1em;
  padding: 12px 20px;
  background: #eea508;
  border: none;
  border-radius: 5px;
  color: #fff;
  text-decoration: none;
}
.supr {
  font-size: 1em;
  padding: 5px;
  background: #d60101;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
}
.edit {
  font-size: 1em;
  padding: 5px;
  background: #0d7ae0;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
}
.supc {
  font-size: 1em;
  padding: 5px;
  background: #0cdf17;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
}
.supr:hover {
  color: #fff
}
.edit:hover {
  color: #fff
}
.supc:hover {
  color: #fff
}
.return:hover {
  text-decoration: none;
  color: #ffff;
}
.alert {
  width: 100%;
  margin-top: 19px;
}
.botonera {
  width: 50%;
  display: flex; 
  justify-content: space-between; 
  align-items: flex-start;
}
@media (max-width: 500px) {
  .formulario, .formulario2 {
    width: 95%;
    padding: 10px;
    border-radius: 10px;
    margin-left: 0;
  }
  .buttonmovil {
    padding: 5px 10px;
  }
  .formulario2 {
    margin-top: 20px;
  }
  .create  {
    margin-top: 30px;
    margin-bottom: 30px;
    width: 95%;
    padding: 20px 0;
    border-radius: 10px;
  }

  .input {
    margin-bottom: 15px;
  }
  .textarea{
    max-width: 100%;
    min-width: 100%;
  }
  .inputother {
    max-width: 100%;
  min-width: 100%;
    margin-bottom: 15px;
  }

  input,
  select {
    border-radius: 3px;
  }

  label {
    margin-bottom: 5px;
    font-weight: 300;
    width: 150px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }
  .botonera {
    width: 95%;
  }
}
</style>