<template>
<div>
    <div class="col-lg-4 col-6">
            <!-- small card -->
            <div class="small-box bg-blue panel-heading cardy">
              <div class="inner">
                <h3>{{ amount }}</h3>
                <p>{{title}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-address-card"></i>
              </div>
              <a href="/clients" class="small-box-footer">
                Info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
</div>   
</template>


<script>
    export default {
        
     mounted() {
            console.log('Component ClientCounter mounted.')
           this.getData();
           },
     data: function () {
          return {
            amount: "",
          }
    },
    props: {
           prefUrl: { type: String,default:null},
           router: "",
           title: "",
          },
    methods: {
        getData: function (){
         var url = this.prefUrl+this.router;
            axios.get(url).then(response => {
              this.amount=response.data;
            });
        },
     }
}
</script>