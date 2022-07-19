<template>
	<div>
		<h1>Login</h1>
		<form>
			<div class="mb-3">
				<label for="email" class="form-label">Email address</label>
				<input
					v-model="user.email"
					type="email"
					class="form-control"
					aria-describedby="emailHelp"
				/>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Password</label>
				<input
					v-model="user.password"
					type="password"
					class="form-control"
					id="exampleInputPassword1"
				/>
			</div>

			<button @click.prevent="login" type="submit" class="btn btn-primary">
				Login
			</button>
		</form>
	</div>
</template>

<script>
import Auth from '../Auth.js';

export default {
	data() {
		return {
			user: {
				email: '',
				password: ''
			}
		};
	},

	methods: {
		login() {
			this.axios
				.post('/api/login', this.user)
				.then(({ data }) => {
					Auth.login(data.access_token, data.user);
					this.$store.dispatch('login');
					this.$router.push('/dashboard');
				})
				.catch((error) => {
					console.log(error);
				});
		}
	}
};
</script>
