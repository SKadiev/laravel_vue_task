<template>
	<form @submit.prevent="add">
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" class="form-control" v-model="task.title" />
		</div>
		<div class="form-group" style="margin-bottom: 10px">
			<label for="description">Description</label>
			<input type="text" class="form-control" v-model="task.description" />
		</div>
		<Datepicker v-model="task.expiration"></Datepicker>

		<button type="submit" class="btn btn-primary">Submit</button>
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
			}
		};
	},
	methods: {
		add() {
			this.axios
				.post('/api/task/add', this.task, {
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
