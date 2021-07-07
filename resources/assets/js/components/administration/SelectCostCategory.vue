<template>
<div>
<!-- paymethodId:{{payMethodId}}
bankId:{{bankId}}
accountId:{{accountId}}
cashboxId:{{cashboxId}} -->
         <div class="form-group col-md-9">
            <label for="description" class="form-group">CATEGORIAS DE COSTOS</label>
            <v-select :options="costCategoryList" @input="getSubcategories()"   v-model="costCategoryId" :reduce="costCategoryList => costCategoryList.costCategoryId" label="categoryName"/>
         </div>

           <div class="form-group col-lg-8" v-if="costCategoryId">
            <label for="bankId">SUBCATEGORIA DE COSTO</label>
            <v-select :options="costSubcategoryList" @input="getSubcategoriesDetail()" v-model="costSubcategoryId" :reduce="costSubcategoryList => costSubcategoryList.costCategoryId" label="categoryName"/>
          </div>  

          <div class="form-group col-lg-8" v-if="costSubcategoryId">
            <label for="accountId">DETALLE DE SUBCATEGORIA</label>:<br> 
             <v-select :options="costSubcatDetailList" v-model="costSubcategoryDetailId" :reduce="costSubcatDetailList => costSubcatDetailList.costCategoryId" label="categoryName"/>
          </div> 

</div>   
</template>


<script>
    export default {
        
     mounted() {
            console.log('Component SelectCostCategory mounted.')
                       this.costCategoryId          = this.propCostCategoryId;
                       this.costSubcategoryId       = this.propCostSubcategoryId;
                       this.costSubcategoryDetailId = this.propCostSubcategoryDetailId;

               axios.get('/cost-categories').then(response => {
                 this.costCategoryList = response.data 
                 console.log(this.costCategoryList)
                });  
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
              // this.accountId = this.costSubcategoryList[0].accountId;
            });
        },
        getSubcategoriesDetail: function (){
         var url = `/cost-categories/${this.costSubcategoryId}/subcategories`;
            axios.get(url).then(response => {
              this.costSubcatDetailList = response.data;

            });
        },

     }
}
</script>