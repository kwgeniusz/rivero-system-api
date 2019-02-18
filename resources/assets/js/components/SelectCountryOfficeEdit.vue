<template>
<div>
   <div class="col-xs-6">
         <div class="form-group">
            <label for="countryId">Pais</label>
            <select v-model="firstOption" v-on:change="getOffices()" class="form-control" name="countryId" id="countryId">
                <option v-for="(item, index) in list" :value="item.countryId"  >{{item.countryName  }}</option>
            </select>
          </div>  
        </div>  
 
      <div class="col-xs-6">
         <div class="form-group">
            <label for="officeId">Oficina</label>
            <select v-model="secondOption"  v-if="firstOption" class="form-control" name="officeId" id="officeId" >
             <option v-for="(item, index) in list2" :value="item.officeId">{{ item.officeName}}</option>
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
            this.getOffices();
        },
     data: function () {
          return {
           firstOption: this.country,
           list: {},
           secondOption: this.office,
           list2: {}
          }
    },
    props: {
           country: { type: Number},
           office: { type: Number}
    },
    methods: {
       allCountrys: function (){
            var url ='../../countrys/all';
            axios.get(url).then(response => {
               console.log(response.data)
             this.list = response.data
            });
        },
       getOffices: function (){
            var url ='../../offices/'+this.firstOption;
            axios.get(url).then(response => {
               console.log(response.data)
               this.list2 = response.data
            });
        },
      }
}
</script>
