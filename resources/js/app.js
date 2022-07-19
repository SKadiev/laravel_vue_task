require('./bootstrap');
import { createApp } from 'vue';

import axios from 'axios';
import VueAxios from 'vue-axios';
import Auth from './Auth.js';
import router from './routes.js';
import App from './App.vue';
import { createStore } from 'vuex';
const store = createStore({
	state() {
		return {
			isLoggedin: false
		};
	},
	mutations: {
		login(state) {
			state.isLoggedin = true;
		},

		logout(state) {
			state.isLoggedin = false;
		}
	},
	getters: {
		isLoggedin(state) {
			return state.isLoggedin;
		}
	},

	actions: {
		login(context) {
			context.commit('login');
		},
		logout(context) {
			context.commit('logout');
		}
	}
});
const app = createApp(App);
app.use(store);
app.use(router);
app.provide('$auth', Auth);
app.use(VueAxios, axios);
app.mount('#app');
