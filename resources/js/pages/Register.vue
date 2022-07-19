<template>
	<div>
		<h1>Register</h1>

		<form>
			<div class="mb-3">
				<label for="name" class="form-label">Name</label>
				<input v-model="user.name" type="text" class="form-control" />
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Email address</label>
				<input
					type="email"
					class="form-control"
					aria-describedby="emailHelp"
					v-model="user.email"
				/>
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Password</label>
				<input v-model="user.password" type="password" class="form-control" />
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">Confirm Password</label>
				<input
					v-model="user.password_confirmation"
					type="password"
					class="form-control"
				/>
			</div>
			<div class="mb-3">
				<label style="margin-right: 10px" for="checkbox">Admin </label>
				<input type="checkbox" v-model="user.is_admin" />
			</div>
			<button @click.prevent="register()" type="submit" class="btn btn-primary">
				Login
			</button>
		</form>
	</div>
</template>

<script>
export default {
	data() {
		return {
			user: {
				name: '',
				email: '',
				password: '',
				password_confirmation: '',
				is_admin: false
			}
		};
	},

	methods: {
		register() {
			console.log(this.user);
			this.axios
				.post('/api/register', this.user)
				.then(({ data }) => {
					this.$router.push('/login');
				})
				.catch((error) => {
					console.log(error);
				});
		}
	}
};
</script>
