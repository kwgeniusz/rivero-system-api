<template>
<div>

   <div class="col-xs-12">
         <div class="form-group">
            <label for="countryId">Pais</label>
            <select v-model="firstOption" v-on:change="getOffices()" class="form-control" name="countryId" id="countryId">
                <option v-for="(item, index) in list" :value="item.countryId"  >{{item.countryName  }}</option>
            </select>
          </div>  
        </div>  
 
      <div class="col-xs-12">
         <div class="form-group">
            <label v-if="firstOption" for="officeId">Oficina</label>
            <select v-model="secondOption" v-on:change="getContracts()"  v-if="firstOption" class="form-control" name="officeId" id="officeId" >
             <option v-for="(item, index) in list2" :value="item.officeId">{{ item.officeName}}</option>
            </select>
          </div> 
    </div>
    
    <!-- /////////////////////////////////////////////-->

    <div class="col-xs-12">
         <div class="form-group">
            <label v-if="secondOption" for="contractNumber"><label class="fa fa-file-contract"></label> N° Contrato</label>
            <select v-model="thirdOption"  v-if="secondOption" class="form-control" name="contractNumber" id="contractNumber" >
             <option v-for="(item, index) in list3" :value="item.contractId">{{ item.contractNumber}}</option>
            </select>
          </div> 
    </div>

   <input class="btn btn-primary" v-if="thirdOption" type="submit" value="Buscar"></input>
  <br><br>
</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component mounted.')
            this.allCountrys();
        },
     data: function () {
          return {
           firstOption: null,
           secondOption: null,
           thirdOption: null,
           list: {},
           list2: {},
           list3: {}
          }
    },

    methods: {
       allCountrys: function (){
            var url ='countrys/all';
            axios.get(url).then(response => {
               console.log(response.data)
             this.list = response.data
            });
        },
       getOffices: function (){
           this.secondOption =null,
           this.thirdOption=null,
           this.list3={}

            var url ='offices/'+this.firstOption;
            axios.get(url).then(response => {
               console.log(response.data)
               this.list2 = response.data
            });
        },
      getContracts: function (){
            var url ='contracts-office/'+this.secondOption;
            axios.get(url).then(response => {
               console.log(response.data)
               this.list3 = response.data[0];
          
            });
        },
      }
}
</script>
