<template>
	<div>
		<component
			v-bind:is="currentTabComponent"
		></component>
		<div class="form-group col-ms-12 col-md-12 col-lg-12 text-center">
			<button v-if="currentComponent === 'LisPreVacation'" v-on:click="currentComponent = 'AddPreVacation'" type="button" class="btn btn-success"><span class="fa fa-plus"></span> Agregar</button>
			<button v-if="currentComponent === 'AddPreVacation'" v-on:click="currentComponent = 'LisPreVacation'" type="button" class="btn btn-warning"><span class="fa fa-plus"></span> Regresar</button>
		</div>
		<component
			v-bind:is="currentComponentVacation"
		></component>
		<!-- <LisPreVacation /> -->
	</div>
</template>

<script>
// @ is an alias to /src

import LisPreVacation from './LisPreVacation.vue'
import AddPreVacation from './AddPreVacation.vue'
import ListVacation from './ListVacation.vue'

export default {
	components: {
		LisPreVacation,
		AddPreVacation,
		ListVacation,
	},
	data() {
		return {
			currentComponent: 'LisPreVacation',
			currentCompVacatio: 'ListVacation'
		}
	},
	mounted() {
		
	},
	computed: {
		currentTabComponent: function () {
			return this.currentComponent
		},
		currentComponentVacation: function () {
			return this.currentCompVacatio
		}
	},
	methods: {

	},
}
</script>
<style scoped>

</style>