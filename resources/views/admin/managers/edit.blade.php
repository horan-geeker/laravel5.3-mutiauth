<script src='//cdn.bootcss.com/socket.io/1.3.7/socket.io.js'></script>
<script>
    // 如果服务端不在本机，请把127.0.0.1改成服务端ip
    var socket = io('http://127.0.0.1:3120');
    // 当连接服务端成功时触发connect默认事件
    socket.on('connect', function(){
        console.log('connect success');
    });
</script>