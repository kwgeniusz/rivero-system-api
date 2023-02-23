<template>
    <div class="">  
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-cost-category
                @showlist = "showlist"
                :editId=0
              ></addUp-cost-category> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <addUp-cost-category
                @showlist = "showlist"
                :editId=editId                
            > </addUp-cost-category> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>CATEGORIA DE COSTOS</b></h3>
           <center>
             <a class=" btn btn-warning" href="/transactions/-/index" type="button">
              <span class="fa fa-hand-point-left"></span> Regresar
             </a>
            </center>
            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>
 
            <table-cost-category  
                :costCategoryList = costCategoryList
                @editData = "editData"
                @showlist = "showlist">
            </table-cost-category>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            axios.get('/cost-categories').then((response) => {
                this.costCategoryList = response.data
            })
        },
        data() {
            return{
                costCategoryList: [],
                // parents: [],
                formStatus: 0,
                editId: '',
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },

            editData(id){
                this.editId = id
                this.formStatus = 2
            }, 

            showlist(n){
                this.formStatus = 0
                axios.get('/cost-categories').then((response) => {
                    this.costCategoryList = response.data
                })
            
            
            },
        }
    }

</script>