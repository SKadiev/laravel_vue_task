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
				expiration: new Date()
			},
			loading: true
		};
	},

	mounted() {
		this.load();
	},

	methods: {
		update() {
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
					console.log(data);
					this.task = data.data;
					console.log(this.task);
					this.loading = false;
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
</style>
