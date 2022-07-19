<template>
	<div class="card w-100 task">
		<div class="card-body task">
			<h5 class="card-title">{{ taskTitle }}</h5>
			<p>{{ taskDescription }}</p>
			<Datepicker
				v-model="taskExpiration"
			></Datepicker>
		</div>
	</div>
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
	components: { Datepicker },

	props: {
		taskTitle: String,
		taskDescription: String,
		tasksStatusId: {
			default: 1,
			type: Number
		},
		taskExpiration: String
	},
	methods: {

	}
};
</script>

<style scoped>
.task {
	margin-bottom: 10px;
}
</style>
