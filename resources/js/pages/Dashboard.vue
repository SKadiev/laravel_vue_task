<template>
	<div>
		<h1>Dashboard</h1>
		<router-link :to="{path: 'Tasks'}">Tasks</router-link>
		<br />
		<p>{{ user.name }}</p>
	</div>
</template>
<script>
export default {
	data() {
		return {
			user: this.$auth.user
		};
	},
	created() {
		console.log(this.$auth.user);
	},
	inject: ['$auth']
};
</script>
