<template>
<div>

   <div class="col-xs-12 col-lg-6">
         <div class="form-group">
            <label for="countryId">PAIS</label>
            <select v-model="firstOption" class="form-control" name="countryId" id="countryId" required="on">
                <option v-for="(item, index) in list" :value="item.countryId">{{item.countryName}}</option>
            </select>
          </div>  
        </div>  

      <div class="col-xs-12 col-lg-6" v-if="firstOption">
         <div class="form-group">
            <label for="companyId">COMPAÑIA</label>
            <select v-model="secondOption" @change="companyValue" class="form-control" name="companyId" id="companyId" required="on">
             <option v-for="(item, index) in list2" :value="item.companyId">{{ item.companyName}}</option>
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
            this.firstOption = this.countryId;
            this.secondOption = this.companyId;
        },
     data: function () {
          return {
           firstOption: null,
           list: {},
           secondOption: null,
           list2: {}
          }
    },
      props: {
           prefUrl: { type: String},
           countryId: { type: String,default: null},
           companyId: { type: String,default: null}
    },
     watch: {
      firstOption: function () {   
      var url2 =this.prefUrl+'companies/'+this.firstOption;
            axios.get(url2).then(response => {
               this.list2 = response.data
            });
        }, 
    },
    methods: {
       allCountrys: function (){
            var url =this.prefUrl+'countrys/all';
            axios.get(url).then(response => {
             this.list = response.data
            });
        },
       companyValue: function (){
             this.$emit("company-value", this.secondOption);
        },
      }
}
</script>
