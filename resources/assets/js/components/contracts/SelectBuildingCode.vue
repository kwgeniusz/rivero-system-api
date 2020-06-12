<template>
<div>

   <div class="row"></div>
   <div class="col-xs-12 col-lg-8">
         <div class="form-group">
            <label for="buildingCodeId">INTERNATIONAL BUILDING CODE (IBC)</label>
            <select v-model="firstOption" class="form-control" name="buildingCodeId" id="buildingCodeId" required="on">
                <option v-for="(item, index) in list" :value="item.buildingCodeId"  >{{item.buildingCodeName}}</option>
            </select>
          </div>  
        </div>  

   <div class="row"></div>
      <div class="col-xs-6" v-if="firstOption">
         <div class="form-group">
            <label for="groupId">GRUPO</label>
            <select v-model="secondOption" class="form-control" name="groupId" id="groupId" required="on">
             <option v-for="(item, index) in list2" :value="item.groupId">{{ item.groupName}}</option>
            </select>
          </div> 
    </div>

    <div class="row"></div>
      <div class="col-xs-12 col-lg-6" v-if="firstOption">
         <div class="form-group">
            <label for="projectUseId">USO DEL PROYECTO</label>:
            <input v-model="thirdOption" type="hidden" name="projectUseId">
                                                         {{list3[0].projectUseName}}
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
           secondOption: this.propBuildingCodeGroup,
           thirdOption: this.propProjectUse,
           list: {},
           list2: {},
           list3: {},
          }
    },
      props: {
           prefUrl: { type: String},
           propBuildingCode: { type: String, default: null}, 
           propBuildingCodeGroup: { type: String, default: null}, 
           propProjectUse: { type: String, default: null}, 
    },
    watch: {
      firstOption: function () {   
     //BUSCAR EN ARREGLO DE JAVASCRIPT /SERVICE/ EL ID QUE SELECCIONO EL USUARIO PARA TRAER EL NOMBRE DEL SERVICIO
        let firstOption = this.firstOption;
           // console.log('la funcion')
        function filtrarPorID(obj) {
          if ('buildingCodeId' in obj && obj.buildingCodeId == firstOption) {
            return true;
          } else {
            return false;
          }
        }
        let projectUseSelected = this.list.filter(filtrarPorID);

          let url2 =this.prefUrl+'buildingCode/'+this.firstOption+'/groups';
          let url3 =this.prefUrl+'projectUses/'+projectUseSelected[0].projectUseId;

            axios.get(url2).then(response => {
             this.list2 = response.data

                     axios.get(url3).then(response => {
                      this.list3 = response.data
                      this.thirdOption=this.list3[0].projectUseId;
                      // alert(this.thirdOption)
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
