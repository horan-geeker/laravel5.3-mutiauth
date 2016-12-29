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

Vue.config.debug = true;//开启错误提示

// Define a new component called todo-item
Vue.component('todo-item', {
	props: ['todo'],
	template: '<li>This is a {{ todo.text }}</li>'
})


const app = new Vue({
	el: '#app',
	created: function () {
		var xhr = new XMLHttpRequest()
		var self = this
		xhr.open('GET', '/api/users')
		xhr.onload = function () {
			self.users = JSON.parse(xhr.responseText)
			// console.log(self.users[0].html_url)
		}
		xhr.send()
	},
	data: {
		msg: 'hello world',
		message: 'hi hejunwei hahahahahaha',
		// users: [
		// 	{name: 'hejunwei', email: 'hejunwei@gmail.com'},
		// 	{name: 'test', email: 'test@gmail.com'}
		// ],
		users: null,
		todos: [
			{text: 'Add some todos'}
		],
		newTodo: '',
		groceryList: [
			{text: 'Vegetables'},
			{text: 'Cheese'},
			{text: 'Whatever else humans are supposed to eat'}
		],

	},
	methods: {
		reverseMessage: function () {
			this.msg = this.msg.split('').reverse().join('')
		},
		addTodo: function () {
			var text = this.newTodo.trim()
			if (text) {
				this.todos.push({text: text})
				this.newTodo = ''
			}
		},
		removeTodo: function (index) {
			this.todos.splice(index, 1)
		},
	},
	components: {
		Example, Navbar,Foot
	}
});
