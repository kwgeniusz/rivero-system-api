<template>
<div> 
      <b>CATEGORIA: </b>
    	<select v-model="choice" placeholder="pick" @change="sendValue($event)">
      	<template v-for="someChoice in choices">
        	<option :value="[someChoice]">{{ someChoice.accountCode}} - {{someChoice.categoryName }}</option>
        </template>
      </select>
      <br>
      <recursive-select v-if="choice && choice[0].children_category_tree && choice[0].children_category_tree.length" :choices="choice[0].children_category_tree">
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
      //  bus: function (event) {
      //   this.$emit('bus', event)
      //  }
        sendValue: function (event){
          // console.log(this.choice)
          // console.log(event.target)
          
             this.$emit('sendCategory', this.choice)
        },
     }
}
</script>