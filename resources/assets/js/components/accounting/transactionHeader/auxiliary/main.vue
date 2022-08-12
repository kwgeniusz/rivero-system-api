<template>
  <div class="row">

       <a @click="openModal" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Auxiliares">
           <i class="fa fa-book"></i>Auxiliares 
       </a>

    <sweet-modal ref="modalNew" width="70%">
      <h3 class="bg-info"><b>Auxiliares de la Transacciones: </b></h3>
        <!-- agregar -->
        <div class="row ">
          <div class="col-xs-12">
           <form class="form-inline" role="form" @submit.prevent="createUpdateClient()"> 
              <div class="form-group">
                <label for="selectAuxiliary"><i class="fa fa-book"></i> Auxiliares Disponibles:</label>
                <v-select v-model="selectedAuxiliary" :options="accountAuxiliaryList" :reduce="accountAuxiliaryList => accountAuxiliaryList" label="item_data" id="selectAuxiliary"/>
              </div>
              <div class="form-group">
                <label for="amount"><i class="fa fa-dollar-sign" aria-hidden="true"></i>  Monto:</label><br>
                <input v-model="selectedAuxiliary.amount" type="number" step="0.01" min="0" class="form-control" id="amount"  pattern="^[0-9]+" >
              </div>
              <br>
                <a @click="createAuxiliaryLink" class="btn btn-info">
                     <span class="fa fa-plus" aria-hidden="true"></span> Agregar
                 </a>
         </form>
        </div>
      </div>
      <br>
        <!-- Tabla y actualizacion de campos -->
             <div class="col-xs-12">
                <div class="panel panel-default">         
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>TIPO</th>
                                <th>AUXILIAR</th>
                                <th>MONTO</th>
                                <th>ACCIONES</th>            
                               </tr>
                            </thead>
                           <tbody v-if="auxiliaryTable.length > 0">      
                             <tr v-for="(item, index) in auxiliaryTable">
                                <td >{{index + 1}} </td>
                                <td class="text-left"> {{item.auxiliary.entity.entityName}}</td>
                                <td class="text-left"> {{item.auxiliary.auxiliaryCode}} - {{item.auxiliary.auxiliaryName}}</td>
                                <td class="text-left">  {{item.auxiliary.amount}}</td>
                                <td> 
                                   <a @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                    <span class="fa fa-times-circle" aria-hidden="true"></span> 
                                   </a>
                                </td>
                              </tr>               
                        </tbody>
                       <tbody v-else>
                           <tr>
                             <td colspan="12">
                                 Sin Registros
                             </td>
                          </tr>
                         </tbody>     
                     </table>

                    </div>
                </div>
            </div>
<br>

      </sweet-modal>     
    </div>        
</template>

<script>
    export default {
        mounted(){},
        data() {
            return{
                accountAuxiliaryList: [],
                selectedAuxiliary: '',

                auxiliaryTable: [],
                editId: '',
            }
        },
        props: {
          generalLedger:'',
        },
        methods: {
            openModal() {
              this.$refs.modalNew.open()
              this.getAccountAuxiliaries()
            },
            createAuxiliaryLink(){
                 this.auxiliaryTable.push({
                                  auxiliary:this.selectedAuxiliary,
                                   });
            },
            editRow(id){
                console.log('el id es: ' + id)
                // this.editId = id
            }, 
            deleteRow: function(id) {
            //borrar valor que encuentre del arreglo
                 this.auxiliaryTable.splice(--id,1);
           }, 
            getAccountAuxiliaries(){
                axios.get(`general-ledgers/${this.generalLedger.generalLedgerId}/auxiliaries`).then((response) => {
                    this.accountAuxiliaryList = response.data
                    this.accountAuxiliaryList.map(function (x){
                       return x.item_data = `${x.auxiliaryCode} - (${x.auxiliaryName})`;
                    });
                    // console.log(this.accountAuxiliaryList)
                })
            },
        }
    }

</script>