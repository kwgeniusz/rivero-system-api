<template>
<div>

   <div class="row"></div>
   <div class="col-xs-8">
         <div class="form-group">
            <label for="buildingCodeId">BUILDING CODE</label>
            <select v-model="firstOption" class="form-control" v-on:change="getProjectUseDescription()" name="buildingCodeId" id="buildingCodeId" required="on">
                <option v-for="(item, index) in list" :value="item.buildingCodeId"  >{{item.buildingCodeName}}</option>
            </select>
          </div>  
        </div>  


    <div class="row"></div>
      <div class="col-xs-6" v-if="firstOption">
         <div class="form-group">
            <label for="projectUseId">USO DEL PROYECTO</label>:
            <input v-model="secondOption" type="hidden" name="projectUseId">
                                                         {{list2[0].projectUseName}}
          </div>
           
    </div>

   <div class="row"></div>
      <div class="col-xs-6" v-if="firstOption">
         <div class="form-group">
            <label for="projectDescriptionId">DESCRIPCION DEL PROYECTO</label>
            <select v-model="thirdOption" class="form-control" name="projectDescriptionId" id="projectDescriptionId" required="on">
             <option v-for="(item, index) in list3" :value="item.projectDescriptionId">{{ item.projectDescriptionName}}</option>
            </select>
          </div> 
    </div>

</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component mounted Building Code.')
            this.getAllBuildingCode();
        },
     data: function () {
          return {
           firstOption: null,
           secondOption: this.propProjectUse,
           thirdOption: this.propProjectDescription,
           list: {},
           list2: {},
           list3: {},
          }
    },
      props: {
           prefUrl: { type: String},
           propBuildingCode: { type: String, default: null}, 
           propProjectUse: { type: String, default: null}, 
           propProjectDescription: { type: String, default: null}, 
    },
    watch: {
      firstOption: function () {   
     //BUSCAR EN ARREGLO DE JAVASCRIPT /SERVICE/ EL ID QUE SELECCIONO EL USUARIO PARA TRAER EL NOMBRE DEL SERVICIO
        let firstOption = this.firstOption;
           console.log('la funcion')
        function filtrarPorID(obj) {
          if ('buildingCodeId' in obj && obj.buildingCodeId == firstOption) {
            return true;
          } else {
            return false;
          }
        }
        var projectUseSelected = this.list.filter(filtrarPorID);

          var url2 =this.prefUrl+'projectUses/'+projectUseSelected[0].projectUseId;
            axios.get(url2).then(response => {
             this.list2 = response.data
             this.secondOption = this.list2[0].projectUseId;

                   var url3 =this.prefUrl+'projectUses/'+this.secondOption+'/descriptions';
                     axios.get(url3).then(response => {
                      this.list3 = response.data
                   });

            });
        }, 
    },
    methods: {
      getAllBuildingCode: function () {
            var url =this.prefUrl+'buildingCode';
            axios.get(url).then(response => {
             this.list = response.data
             this.firstOption= this.propBuildingCode
            });
        },
      }
}
</script>
