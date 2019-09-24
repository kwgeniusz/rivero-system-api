<template>
<div>

    <button class="btn btn-success" @click="this.$refs.modalChangeStatus.open()">click modal</button>
    
     <sweet-modal ref="modalChangeStatus">
         <button class="btn btn-success" slot="button" v-on:click="$refs.nestedChild.open()">Open Child Modal</button>
     </sweet-modal>

     <sweet-modal ref="nestedChild">
              This is the child modal.
     </sweet-modal>

</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component mounted.')
        },
     data: function () {
          return {

          }
    },
    methods: {
       openModal: function (){
            this.$refs.modalChangeStatus.open()
        }
      }
}
</script>
