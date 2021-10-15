<template>
	<div>
		<component
			v-bind:is="currentTabComponent"
		></component>
		<!-- <div class="form-group col-ms-12 col-md-12 col-lg-12 text-center">
			<button v-if="currentComponent === 'LisVacation'" v-on:click="currentComponent = 'AddPreVacation'" type="button" class="btn btn-success"><span class="fa fa-plus"></span> Agregar</button>
			<button v-if="currentComponent === 'AddPreVacation'" v-on:click="currentComponent = 'LisPreVacation'" type="button" class="btn btn-warning"><span class="fa fa-plus"></span> Regresar</button>
		</div> -->
		<!-- <LisPreVacation /> -->
	</div>
</template>

<script>
// @ is an alias to /src

import LisVacation from './LisVacation.vue'

export default {
	components: {
		LisVacation,
	},
	data() {
		return {
    	currentComponent: 'LisVacation'
		}
	},
	mounted() {
		
	},
	computed: {
    currentTabComponent: function () {
    	return this.currentComponent
    }
	},
	methods: {

	},
}
</script>
<style scoped>

</style>