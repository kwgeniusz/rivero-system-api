<template>
<div>
<!-- INPUT BUSCADOR DE CLIENTES AJAX-->
    <div class="form-group col-xs-12">
        <label for="subcontName">SUBCONTRATISTA</label>
      
        <div class="input-group ">
         <input type="hidden" name="subcontId" :value="subcontId">
         <input class="form-control" @keyup="searchSubcontract()" name="subcontName" v-model="subcontName" autocomplete="off" :disabled="btnRemove">
           <span class="input-group-btn">
             <!-- <form-new-subcontractor prefUrl="../../"  v-if="btnAdd" @sendClient="addSubcontractor"/> -->
              <a class="btn btn-primary" v-if="btnAdd"><span class="fa fa-search" aria-hidden="true"></span></a>
             <a class="btn btn-danger" @click="removeSubcontractor()" v-if="btnRemove"><span class="fa fa-times-circle" aria-hidden="true"></span></a>
          </span>
         </div>

    <div :class="{ sugerencias: this.style }">
      <div class="result" v-for="(item, index) in list" @click="addSubcontractor(item)">{{item.subcontName}}</div>
   </div>
  
    </div>

</div>   
</template>

<script>

import FormNewSubcontractor from './FormNewSubcontractor.vue'

    export default {
        
     mounted() {
            console.log('Component SearchSubcontract mounted.')
        },
     data: function () {
          return {
            subcontId: '',
            subcontName : '',
            list : '',
            style : '',
            btnAdd: true,
            btnRemove: false,
          }
    },
     props: {
           // prefUrl: { type: String},
    },
     components: {
         FormNewSubcontractor
  },
    methods: {
       reRender: function() {
        this.removeSubcontractor();
        this.$forceUpdate();
     },
       searchSubcontract: function() {
           if(this.subcontName == '') {
                 this.list = ''
                 this.style =false
           } else { 
              var url ='../../searchSubcontractor/'+this.subcontName;
              axios.get(url).then(response => {
                 this.list = response.data
                 this.style = true
                });
              }
          
         },
       addSubcontractor: function (subcontractor){
         // console.log(subcontractor)
            this.subcontId = subcontractor.subcontId;
            this.subcontName = subcontractor.subcontName;

            this.list = ''
            this.style = false
            this.btnRemove = true
            this.btnAdd = false
            
            this.$emit("subcontractorSelected",this.subcontId);
        },
         removeSubcontractor: function (){
            this.subcontId = '';
            this.subcontName = '';

            this.list = ''
            this.style = false
            this.btnRemove = false
            this.btnAdd = true

            this.$emit("subcontractorRemoved");   
        },
     }
}
</script>

<style lang="scss">
@import '../../../sass/app.scss'
</style>
