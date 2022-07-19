<template>
	<h2 v-if="loading">Loading Tasks !!!!</h2>
	<div v-else>
		<button @click="reverseByExpiration" type="button" class="btn btn-primary">
			Reverse by expiration
		</button>
		<div class="row mb-4" v-for="row in rows" :key="'row' + row">
			<task
				v-for="task in tasks"
				:key="task.id"
				:id="task.id"
				:task-title="task.title"
				:task-description="task.description"
				:tasks_status_id="task.tasks_status_id"
			></task>
		</div>
	</div>
</template>

<script>
import Task from '../../components/Task.vue';

export default {
	data() {
		return {
			loading: true,
			tasks: [],
			columns: 3
		};
	},
	components: { Task },
	methods: {
		getTasks() {
			this.axios
				.get('/api/tasks', this.user, {
					headers: {
						Authorization: 'Bearer ' + localStorage.getItem('token')
					}
				})
				.then(({ data }) => {
					console.log(data);
					this.tasks = data.data;
					this.loading = false;
				})
				.catch((error) => {
					console.log(error);
				});
		},
		reverseByExpiration() {
			this.tasks.sort((a, b) => {
				return new Date(a.expiration) - new Date(b.expiration);
			});
			return this.items;
		}
	},
	mounted() {
		this.getTasks();
	},
	computed: {
		rows() {
			return this.tasks.length === 0
				? 0
				: Math.ceil(this.tasks.length / this.columns);
		}
	}
};
</script>
