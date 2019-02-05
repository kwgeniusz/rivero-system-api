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
             <option v-for="(item, index) in list3" :value="item.contractNumber">{{ item.contractNumber}}</option>
            </select>
          </div> 
    </div>

    <div class="col-xs-12">
         <div class="form-group">
            <label v-if="secondOption" for="clientName"><label class="fa fa-user"></label> Cliente</label>
            <select v-model="fourOption"  v-if="secondOption" class="form-control" name="clientName" id="clientName" >
             <option v-for="(item, index) in list4" :value="item.clientName">{{ item.clientName}}</option>
            </select>
          </div> 
    </div>

        <div class="col-xs-12">
         <div class="form-group">
            <label v-if="secondOption" for="clientPhone"><label class="fa fa-phone"></label> Telefono</label>
            <select v-model="fifthOption"  v-if="secondOption" class="form-control" name="clientPhone" id="clientPhone" >
             <option v-for="(item, index) in list5" :value="item.clientPhone">{{ item.clientPhone}}</option>
            </select>
          </div> 
    </div>

     <div class="col-xs-12">
         <div class="form-group">
            <label v-if="secondOption" for="siteAddress"><label class="fa fa-university"></label> Direccion de la Obra</label>
            <select v-model="sixthOption"  v-if="secondOption" class="form-control" name="siteAddress" id="siteAddress" >
             <option v-for="(item, index) in list6" :value="item.siteAddress">{{ item.siteAddress}}</option>
            </select>
          </div> 
    </div>


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
           fourOption : null,
           fifthOption : null,
           sixthOption : null,
           list: {},
           list2: {},
           list3: {},
           list4: {},
           list5: {},
           list6: {} 
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
           this.fourOption =null,
           this.fifthOption =null,
           this.sixthOption =null,
           this.list3={},
           this.list4={},
           this.list5={},
           this.list6={} 
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
               this.list4 = response.data[1];
               this.list5 = response.data[2];
               this.list6 = response.data[3];
            });
        },
      }
}
</script>
