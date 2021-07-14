<template>
<div>
<!-- paymethodId:{{propCostCategoryId}}
bankId:{{propCostSubcategoryId}}
accountId:{{propCostSubcategoryDetailId}} -->
         <div class="form-group col-md-9">
            <label for="description" class="form-group">CATEGORIAS DE COSTOS</label>
            <v-select :options="costCategoryList" @input="getSubcategories()"   v-model="costCategoryId" :reduce="costCategoryList => costCategoryList.costCategoryId" label="item_data"/>
         </div>

           <div class="form-group col-lg-8" v-if="costCategoryId">
            <label for="bankId">SUBCATEGORIA DE COSTO</label>
            <v-select :options="costSubcategoryList" @input="getSubcategoriesDetail()" v-model="costSubcategoryId" :reduce="costSubcategoryList => costSubcategoryList.costCategoryId" label="item_data"/>
          </div>  

          <div class="form-group col-lg-8" v-if="costSubcategoryId">
            <label for="accountId">DETALLE DE SUBCATEGORIA</label>:<br> 
             <v-select :options="costSubcatDetailList" v-model="costSubcategoryDetailId" :reduce="costSubcatDetailList => costSubcatDetailList.costCategoryId" label="item_data"/>
          </div> 

</div>   
</template>


<script>
    export default {
        
     mounted() {
            console.log('Component SelectCostCategory mounted.')

               axios.get('/cost-categories').then(response => {
                 this.costCategoryList = response.data 
                 this.costCategoryList.map(function (x){
                           return x.item_data = `${x.costCategoryCode} - (${x.categoryName})`;
                 });

                       this.costCategoryId          = this.propCostCategoryId;
                       this.costSubcategoryId       = this.propCostSubcategoryId;
                       this.costSubcategoryDetailId = this.propCostSubcategoryDetailId;
                   console.log(this.propCostCategoryId)
                });  //end axios
     },
     data: function () {
          return {
           costCategoryList: [],
           costSubcategoryList: [],
           costSubcatDetailList: [],

            // errors: [],
            costCategoryId: '',
            costSubcategoryId: '',
            costSubcategoryDetailId:'',
          }
    },
    props: {
           propCostCategoryId:          {type: [String,Number], default: null},
           propCostSubcategoryId:       {type: [String,Number], default: null},
           propCostSubcategoryDetailId: {type: [String,Number], default: null},
          },
    watch: {
     costCategoryId: function () {
          this.costSubcategoryId = '';
          this.costSubcategoryDetailId = '';

          this.$emit("shareData",this.costCategoryId,this.costSubcategoryId,this.costSubcategoryDetailId);
       }, 
      costSubcategoryId: function () {
          this.costSubcategoryDetailId = '';
          this.$emit("shareData",this.costCategoryId,this.costSubcategoryId,this.costSubcategoryDetailId);
       },  
      costSubcategoryDetailId: function () {
          this.$emit("shareData",this.costCategoryId,this.costSubcategoryId,this.costSubcategoryDetailId);
       },   
    },
    methods: {
        getSubcategories: function (){
         var url = `/cost-categories/${this.costCategoryId}/subcategories`;
            axios.get(url).then(response => {
              this.costSubcategoryList = response.data;
              this.costSubcategoryList.map(function (x){
                           return x.item_data = `${x.costCategoryCode} - (${x.categoryName})`;
                 });
            });
        },
        getSubcategoriesDetail: function (){
         var url = `/cost-categories/${this.costSubcategoryId}/subcategories`;
            axios.get(url).then(response => {
              this.costSubcatDetailList = response.data;
              this.costSubcatDetailList.map(function (x){
                           return x.item_data = `${x.costCategoryCode} - (${x.categoryName})`;
                 });
            });
        },

     }
}
</script>