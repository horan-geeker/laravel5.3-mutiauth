<template>
    <div class="container">
        <div class="row">
            <div class="row">
                <div class="col-md-6">
                    Laravel-vue
                </div>
                <div class="col-md-6">
                    {{ msg }}
                    <br>
                    <input type="text" v-model="msg">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li v-for="user in users">
                            name: {{ user.name }} email: {{ user.email }}
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <button @click='reverseMessage'>Reverse Message</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <input v-model="newTodo" @keyup.enter="addTodo">
                    <ul>
                        <li v-for="(todo,index) in todos">
                            <span>{{ todo.text }}</span>
                            <button @click="removeTodo(index)">X</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
</style>
<script>
import Storage from '../../storage.js'

export default{
        created: function () {
            this.$http.get('/api/users').then(function(data){
                this.users = data.body;
            })
        },
        data(){
            return {
                msg:'hello hejunwei',
                users:null,
		        newTodo: '',
                todos: Storage.get('todos')
            }
        },
        methods:{
            reverseMessage: function () {
                this.msg = this.msg.split('').reverse().join('')
            },
            addTodo: function () {
                var text = this.newTodo.trim()
                if (text) {
                    this.todos.push({text: text})
                    Storage.set('todos',this.todos)
                    this.newTodo = ''
                }
            },
            removeTodo: function (index) {
                this.todos.splice(index, 1)
                Storage.set('todos',this.todos)
            },
		},
    }


</script>
