

Vue.component('recursive-input', {
	name: 'recursive-input',
  props: {
  	choices: {}
  },
  data: function() {
  	return {
    	choice: undefined
    }
  },
  template: `
  	<div>
    	<select v-model="choice" placeholder="pick">
      	<template v-for="someChoice in choices">
        	<option :value="someChoice">{{ someChoice.name }}</option>
        </template>
      </select>
      <recursive-input v-if="choice && choice.children && choice.children.length" :choices="choice.children">
      </recursive-input>
    </div>
  `
})