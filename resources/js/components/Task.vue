<template>
	<div class="card w-100 task">
		<div class="card-body task">
			<h5 class="card-title">{{ taskTitle }}</h5>
			<p>{{ taskDescription }}</p>
			<span>{{ tasksStatusId }}</span>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		taskTitle: String,
		taskDescription: String,
		tasksStatusId: {
			default: 1,
			type: Number
		}
	}
};
</script>

<style scoped>
.task {
	margin-bottom: 10px;
}
</style>
