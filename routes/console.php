<?php

use Illuminate\Foundation\Inspiring;
use Workerman\Worker;
use PHPSocketIO\SocketIO;
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
