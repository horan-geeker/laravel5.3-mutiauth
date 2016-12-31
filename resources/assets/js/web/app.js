/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

// Vue.component('example', require('./components/Example.vue'));
import Example from './components/Example.vue'
import Navbar from './components/Navbar.vue'
import Foot from './components/Foot.vue'
import Container from './components/Container.vue'

Vue.config.debug = true;//开启错误提示

const app = new Vue({
	el: '#app',
	components: {
		Example, Navbar,Foot,Container
	}
});
