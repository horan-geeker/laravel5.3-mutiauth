<?php

use Illuminate\Foundation\Inspiring;
use Workerman\Worker;
use PHPSocketIO\SocketIO;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('socket',function (){
    // 创建socket.io服务端，监听2021端口
    $io = new SocketIO(2021);
    // 当有客户端连接时打印一行文字
    $io->on('connection', function($connection)use($io){
        echo "new connection coming\n";
    });

    Worker::runAll();
});

Artisan::command('sendMail', function () {
    $users = \App\Models\User::all();
    foreach ($users as $user) {
        $job = new \App\Jobs\SendEmail($user->email, new \App\Mail\UserNotify('success',['恭喜你注册成功']));
        dispatch($job);
    }
});

Artisan::command('consumer', function () {
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->exchange_declare('logs', 'fanout', false, false, false);

    list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

    $channel->queue_bind($queue_name, 'logs');

    echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

    $callback = function($msg){
        echo ' [x] ', $msg->body, "\n";
    };

    $channel->basic_consume($queue_name, '', false, true, false, false, $callback);

    while(count($channel->callbacks)) {
        $channel->wait();
    }

    $channel->close();
    $connection->close();

});

Artisan::command('producer', function () {
    $connection = new AMQPStreamConnection('127.0.0.1', '5672', 'guest', 'guest');
    $channel = $connection->channel();
    $channel->exchange_declare('logs', 'fanout', false, false, false);

    $message = new AMQPMessage("Hello world");
    $channel->basic_publish($message, 'logs');

    echo " [x] Sent success\n";
    $channel->close();
    $connection->close();
});