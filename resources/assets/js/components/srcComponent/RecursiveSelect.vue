<template>
<div> 
      <b>CATEGORIA: </b>
    	<select v-model="choice" placeholder="pick">
      	<template v-for="someChoice in choices">
        	<option :value="someChoice">{{ someChoice.accountCode}} - {{someChoice.categoryName }}</option>
        </template>
      </select>
      <br>
      <recursive-select v-if="choice && choice.children_category_tree && choice.children_category_tree.length" :choices="choice.children_category_tree">
      </recursive-select>
  </div>
</template>

<script>
    export default {
        
     mounted() {
           console.log('Component Recursive Select mounted.')
          //  this.getData();
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
        // getData: function (){
        //  var url = this.prefUrl+this.router;
        //     axios.get(url).then(response => {
        //       this.amount=response.data;
        //     });
        // },
     }
}
</script>