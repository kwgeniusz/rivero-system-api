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
            <select v-model="secondOption"  v-if="firstOption" class="form-control" name="officeId" id="officeId" >
             <option v-for="(item, index) in list2" :value="item.officeId">{{ item.officeName}}</option>
            </select>
          </div> 
    </div>
    
    <!-- /////////////////////////////////////////////-->


   <input class="btn btn-primary" v-if="secondOption" type="submit" value="Buscar"></input>
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
           list: {},
           list2: {},
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
           this.secondOption =null

            var url ='offices/'+this.firstOption;
            axios.get(url).then(response => {
               console.log(response.data)
               this.list2 = response.data
            });
        },

      }
}
</script>
