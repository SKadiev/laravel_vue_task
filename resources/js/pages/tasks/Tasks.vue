<template>
	<h2 v-if="loading">Loading Tasks !!!!</h2>
	<div v-else>
		<router-link to="/task/add"
			><button type="button" class="btn btn-primary">
				Create Task
			</button></router-link
		>

		<button @click="reverseByExpiration" type="button" class="btn btn-primary">
			Order By
			{{ (expirationDescending ? 'Ascending' : 'Descending') + ' Expiration' }}
		</button>
		<datepicker
			style="margin-bottom: 12px"
			v-model="expiration"
			@update:modelValue="updateExpiration"
		></datepicker>
		<div class="row">
			<div class="col-6">
				<h3>Open tasks</h3>

				<draggable
					class="list-group"
					v-model="tasks"
					group="tasks"
					@start="drag = true"
					@end="end"
					item-key="id"
				>
					<template #item="{ element }">
						<div>
							<task
								:id="element.id"
								:task-title="element.title"
								:task-description="element.description"
								:tasks_status_id="element.tasks_status_id"
								:task_expiration="element.expiration"
							>
							</task>
						</div>
					</template>
				</draggable>
			</div>
			<div class="col-6">
				<h3>Closed tasks</h3>
				<draggable
					class="list-group completed"
					v-model="completedTask"
					group="tasks"
					@start="drag = true"
					@end="drag = false"
					@change="comleteTask"
					item-key="id"
				>
					<template #item="{ element }">
						<div>
							<task
								:id="element.id"
								:task-title="element.title"
								:task-description="element.description"
								:tasks_status_id="element.tasks_status_id"
								:task_expiration="element.expiration"
							>
							</task>
						</div>
					</template>
				</draggable>
			</div>
		</div>
	</div>
</template>

<script>
import Task from '../../components/Task.vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import draggable from 'vuedraggable';

export default {
	display: 'Two Lists',
	order: 1,
	data() {
		return {
			loading: true,
			tasks: [],
			completedTask: [],
			columns: 3,
			expirationDescending: true,
			expiration: new Date(),
			drag: false
		};
	},
	components: { Task, Datepicker, draggable },
	methods: {
		getTasks() {
			this.axios
				.get('/api/tasks', this.user, {
					headers: {
						Authorization: 'Bearer ' + localStorage.getItem('token')
					}
				})
				.then(({ data }) => {
					this.tasks = data.data;
					this.completedTask = this.tasks.filter(
						(e) => e.taskStatusName === 'completed'
					);
					this.tasks = this.tasks.filter(
						(e) => e.taskStatusName !== 'completed'
					);
					this.tasks.filter((e) => console.log(e));
					this.loading = false;
				})
				.catch((error) => {
					console.log(error);
				});
		},

		testDrag(e) {
			this.drag = false;
			console.log('test drag end', e.to, e);
		},
		reverseByExpiration() {
			this.loading = true;

			this.tasks.sort((a, b) => {
				if (this.expirationDescending) {
					return (
						Number(new Date(a.expiration)) - Number(new Date(b.expiration))
					);
				} else {
					return (
						Number(new Date(b.expiration)) - Number(new Date(a.expiration))
					);
				}
			});
			this.expirationDescending = !this.expirationDescending;
			setTimeout(() => {
				this.loading = false;
			}, 100);
		},
		updateExpiration() {
			const expiration = this.expiration
				.toISOString()
				.slice(0, 19)
				.replace('T', ' ');

			this.axios
				.get(`/api/tasks/expiration/${expiration}`, this.user, {
					headers: {
						Authorization: 'Bearer ' + localStorage.getItem('token')
					}
				})
				.then(({ data }) => {
					this.tasks = data.data;
				})
				.catch((error) => {
					console.log(error);
				});
		},

		end: function (e) {
			this.drag = false;
			console.log(e);
		},
		comleteTask(e) {
			if (e.added) {
				const task = e.added.element;
				task.tasks_status_id = 2;
				delete task.taskStatusName;
				this.updateTask(task);
			}
		},
		updateTask(task) {
			this.axios
				.post('/api/task/update', task, {
					headers: {
						Authorization: 'Bearer ' + localStorage.getItem('token')
					}
				})
				.then(({ data }) => {
					console.log(data);
				})
				.catch((error) => {
					console.log(error);
				});
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

<style scoped>
button {
	margin-right: 10px;
	margin-bottom: 10px;
}
</style>
