<template>
	<div class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="collapse navbar-collapse">
				<div class="navbar-nav" v-if="isLoggedIn">
					<router-link style="padding-right: 1rem" to="/"
						><button type="button" class="btn btn-light">
							Home
						</button></router-link
					>
					<router-link style="padding-right: 1rem" to="/tasks"
						><button type="button" class="btn btn-light">
							Tasks
						</button></router-link
					>
					<a
						href="javascript:void(0)"
						@click="logout()"
						class="nav-item nav-link ml-3"
						>Logout</a
					>
				</div>
				<div v-else>
					<router-link style="padding-right: 1rem" to="/login"
						><button type="button" class="btn btn-primary">
							Login
						</button></router-link
					>

					<router-link style="padding-right: 1rem" class="mr-2" to="/register"
						><button type="button" class="btn btn-primary">
							Register
						</button></router-link
					>
				</div>
			</div>
		</nav>
		<router-view> </router-view>
	</div>
</template>

<script>
import Auth from './Auth.js';
export default {
	data() {
		return {
			loggedUser: this.$auth.user
		};
	},
	mounted() {
		console.log(this.$auth.user);
	},
	methods: {
		logout() {
			this.axios
				.post('/api/logout')
				.then(({ data }) => {
					Auth.logout(); //reset local storage
					this.$store.dispatch('logout');
					this.$router.push('/login');
				})
				.catch((error) => {
					console.log(error);
					window.localStorage.clear();
					this.$router.push('/login');
				});
		},
		home() {
			this.$router.push('/');
		}
	},
	inject: ['$auth'],

	computed: {
		isLoggedIn() {
			// if (localStorage.getItem('user')) {
			// 	return true;
			// }
			return this.$store.getters.isLoggedin;
		}
	}
};
</script>
