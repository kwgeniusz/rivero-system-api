<template>
<div>

<div>
    <div class="col-xs-4">
     <!-- Total Transacciones: ${{totals.subcontractors}} <br>
     Manuales: ${{totals.manuales}} <br>
     Fee: ${{totals.fee}} <br>
     Total: ${{totals.netTotal}} <br> -->
    </div>   

    <div class="col-xs-4">
       <input type="text" placeholder="Buscar" class="form-control" v-model="inputSearch">
    </div> 

   <div class="col-xs-4">
    
    </div>
</div>

 <br>

      <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="table-responsive text-center">

                        <table class="table table-striped table-bordered text-center" style="border: 1px solid #ddd !important;">
                            <thead class="bg-success">
                              <tr>
                                  <th>#</th> 
                                  <th>TIPO TAX ID</th> 
                                  <th>TAX ID</th>
                                  <th>TIPO</th>
                                  <th>COMPANIA<br>
                                   (RESPONSABLE / CLIENTE)
                                  </th>
                                  <th>DIRECCION DE FACTURACION</th>
                                  <th>TELEFONO</th>
                                  <th>CORREO</th> 
                                  <th>SERVICIO QUE OFRECE</th>
                                  <th>TIPO 1099</th> 
                                  <th>ACCIONES</th> 
                              </tr>
                            </thead>
                            <tbody v-if="searchData.length > 0">
                             <tr  v-for="(subcontractor, index) in searchData" :key="subcontractor.subcontractorId">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{subcontractor.typeTaxId}}</td>  
                                <td class="text-left"> {{subcontractor.taxId}} </td>           
                                <td class="text-left">{{subcontractor.subcontType}}</td>
                                <td class="text-left">
                                   <p v-if="subcontractor.companyName != 'No Info'"> 
                                       {{subcontractor.companyName}}
                                        </p>
                                   <p v-if="subcontractor.subcontractorName != 'No Info'">
                                       ({{subcontractor.subcontractorName}}) 
                                       </p>
                                </td>
                                <td class="text-left">{{subcontractor.address}}</td>
                                <td class="text-left">{{subcontractor.mainPhone}}</td>
                                <td class="text-left">{{subcontractor.mainEmail}}</td>
                                <td class="text-left">{{subcontractor.serviceOffered}}</td>
                                <td class="text-left">{{subcontractor.typeForm1099}}</td>
                                  <td> 
                      
                                 <button v-if="$can('BAB')" @click="editSubcontractor(index,subcontractor.subcontId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                 <!-- <button v-if="$can('BAC')"  @click="deleteSubcontractor(index,subcontractor.subcontId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>   -->
                                 <a v-if="$can('BAB')" :href="'subcontractors/'+subcontractor.subcontId+'/payables'" class="btn btn-sm btn-success" title="Cuentas por Pagar"><span class="fa fa-user" aria-hidden="true"></span></a> 
                         
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
    export default {
    mounted() {
            console.log('Component mounted.') 
            // console.log(this.subcontractorList)
        },
     data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            subcontractorList:  {  type: [Array], default: null},
        },  
         computed: {
            searchData: function () {
                return this.subcontractorList.filter((subcontractor) => {
                 if(subcontractor.companyName == null ) 
                     subcontractor.companyName = 'No Info'
                  if(subcontractor.subcontractorName == null ) 
                     subcontractor.subcontractorName = 'No Info'
                 
                  return subcontractor.companyName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         subcontractor.subcontractorName.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                })
            }, 
        
        },
        methods: {
            editSubcontractor(index, id){
                this.$emit('editData', id)
            },
            deleteSubcontractor(index, id){
                if (confirm(`Esta Seguro de Eliminar Al Subcontratista #${++index}?`) ){
                    axios.delete(`/subcontractors/${id}`).then((response) => {
                           toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                    })
                }    
            }, 
        }
    }

</script>


