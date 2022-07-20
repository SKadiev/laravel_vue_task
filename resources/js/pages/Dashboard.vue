<template>
	<div>
		<h1>Dashboard</h1>
		<br />
		<p>Hello, {{ user.name }}</p>
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
