import Auth from './Auth.js';
import { createWebHistory, createRouter } from 'vue-router';

import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Dashboard from './pages/Dashboard.vue';

const routes = [
	{
		path: '/login',
		component: Login,
		name: 'Login'
	},
	{
		path: '/register',
		component: Register,
		name: 'Register'
	},
	{
		path: '/dashboard',
		component: Dashboard,
		name: 'Dashboard',
		meta: {
			requiresAuth: true
		}
	}
];

const router = createRouter({
	history: createWebHistory(),
	routes: routes
});

router.beforeEach((to, from, next) => {
	if (to.matched.some((record) => record.meta.requiresAuth)) {
		if (Auth.check()) {
			next();
			return;
		} else {
			router.push('/login');
		}
	} else {
		next();
	}
});

export default router;
