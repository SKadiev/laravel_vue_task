<template>
	<div class="card w-100 task">
		<div class="card-body task">
			<h5 class="card-title">{{ taskTitle }}</h5>
			<p>{{ taskDescription }}</p>
			<router-link :to="{ name: 'EditTask', params: { id: id } }"
				><button type="button" class="btn btn-primary">
					Edit Task
				</button></router-link
			>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {};
	},

	props: {
		id: Number,
		taskTitle: String,
		taskDescription: String,
		tasksStatusId: {
			default: 1,
			type: Number
		},
		taskExpiration: String
	},
	methods: {}
};
</script>

<style scoped>
.task {
	margin-bottom: 10px;
}
button {
	margin: 10px 0;
}
</style>
