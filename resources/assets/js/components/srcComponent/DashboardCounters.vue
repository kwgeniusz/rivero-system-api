<template>
<div>
    <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info panel-heading">
              <div class="inner">
                <h3>{{ amount }}</h3>

                <p>{{title}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="/users" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
</div>   
</template>


<script>
    export default {
        
     mounted() {
            console.log('Component DashboardCounters mounted.')
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