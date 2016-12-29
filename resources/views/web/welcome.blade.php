<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="{{ elixir('assets/css/web/app.css') }}" rel="stylesheet" type="text/css">
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div v-cloak id="app" class="container">
    <navbar></navbar>
    <div class="row">
        <div class="col-md-6">
            Laravel-MutiAuth
        </div>
        <div class="col-md-6">
            @{{ msg }}
            <br>
            <input type="text" v-model="msg">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <ul>
                <li v-for="user in users">
                    name: @{{ user.name }} email: @{{ user.email }}
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <p>@{{ message }}</p>
            <button v-on:click="reverseMessage">Reverse Message</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <input v-model="newTodo" v-on:keyup.enter="addTodo">
            <ul>
                <li v-for="(todo,key,index) in todos">
                    <span>@{{ todo.text }}</span>
                    <button v-on:click="removeTodo(index)">X</button>
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <todo-item v-for="item in groceryList" v-bind:todo="item"></todo-item>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <example></example>
        </div>
    </div>
    <foot></foot>
</div>
<script src="{{ elixir('assets/js/web/app.js') }}"></script>
</body>
</html>
