<template>
	<h1 v-if="loading">Loading !!!!</h1>
	<form v-else @submit.prevent="add">
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" class="form-control" v-model="task.title" />
		</div>
		<div class="form-group" style="margin-bottom: 10px">
			<label for="description">Description</label>
			<input type="text" class="form-control" v-model="task.description" />
		</div>
		<Datepicker v-model="task.expiration"></Datepicker>
		<div class="form-group tote" style="margin-bottom: 10px">
			<select v-if="!loading" v-model="selected">
				<option
					:key="taskStatus.id"
					v-for="taskStatus in taskStatusList"
					:value="taskStatus.id"
				>
					{{ taskStatus.status_name }}
				</option>
			</select>
		</div>
		<button @click.prevent="update" type="submit" class="btn btn-primary">
			Submit
		</button>
	</form>
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
export default {
	components: { Datepicker },
	data() {
		return {
			task: {
				title: '',
				description: '',
				expiration: new Date(),
				taskStatusId: null
			},
			loading: true,
			taskStatusList: [],
			selected: null
		};
	},

	mounted() {
		this.load();
		this.loadTaskStatusList();
	},

	methods: {
		update() {
			this.task.tasks_status_id = this.selected;
			this.axios
				.post('/api/task/update', this.task, {
					headers: {
						Authorization: 'Bearer ' + localStorage.getItem('token')
					}
				})
				.then(({ data }) => {
					this.$router.push('/tasks');
				})
				.catch((error) => {
					console.log(error);
				});
		},

		load() {
			console.log(this.$router);
			this.axios
				.get('/api/task/edit/' + this.$route.params.id, this.task, {
					headers: {
						Authorization: 'Bearer ' + localStorage.getItem('token')
					}
				})
				.then(({ data }) => {
					this.task = data.data;
					this.loading = false;
				})
				.catch((error) => {
					console.log(error);
				});
		},

		loadTaskStatusList() {
			this.axios
				.get('/api/tasks/statusList', {
					headers: {
						Authorization: 'Bearer ' + localStorage.getItem('token')
					}
				})
				.then(({ data }) => {
					this.selected = this.task.tasks_status_id;
					this.taskStatusList = data.data;
				})
				.catch((error) => {
					console.log(error);
				});
		}
	}
};
</script>

<style scoped>
.task {
	margin-bottom: 10px;
}
button {
	margin: 10px 0;
}
.tote {
	margin-top: 1rem;
}
</style>
