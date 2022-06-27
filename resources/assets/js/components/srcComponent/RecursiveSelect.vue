<template>
<div>
    	<select v-model="choice" placeholder="pick">
      	<template v-for="someChoice in choices">
        	<option :value="someChoice">{{ someChoice.name }}</option>
        </template>
      </select>
      <br>
      <recursive-select v-if="choice && choice.children && choice.children.length" :choices="choice.children">
      </recursive-select>
  </div>
</template>

<script>
    export default {
        
     mounted() {
           console.log('Component Recursive Select mounted.')
           this.getData();
           },
     data: function () {
          return {
            	choice: undefined
          }
    },
   props: {
  	choices: {}
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