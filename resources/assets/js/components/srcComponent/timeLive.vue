<template class="inline">
      <div class="col-xs-12 text-right">
    <!-- HORA VENEZUELA -->
     <b> Venezuela: {{currentTime | moment('timezone', 'America/Caracas', 'hh:mm A')}} /
    <!-- HORA DALLAS/HOUSTON -->
       Dallas: {{currentTime | moment('timezone', 'America/Chicago', 'hh:mm A')}} </b>
   </div>
</template>

<script>
    export default {
     mounted() {
            console.log('Component timeLive mounted.')
           },
       created() {
          this.currentTime = new Date();
          setInterval(() => this.updateCurrentTime(), 1 * 1000);
       },
       data: function() {
        return {   
         currentTime: null,
         message: 'Current Time:',
        }
       }, 
        methods: {
          updateCurrentTime: function() {
                 this.currentTime = new Date();
          }
        },
}
</script>

<style>
 .inline {
    display:block-inline;
 }
</style>