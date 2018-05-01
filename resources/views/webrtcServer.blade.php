<!DOCTYPE html>
<html lang="ZH-CN">
<head>
    <meta charset="utf-8">
    <title>web RTC 测试</title>
    <style>
        .booth {
            width:400px;

            background:#ccc;
            border: 10px solid #ddd;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
<div class="booth">
    <video id="video" width="400" height="300"></video>
    <canvas id='canvas' width='400' height='300'></canvas>
    <img id='img' src=''>
</div>


<script>
    // websocket 
    //const WebSocket = require('ws');
    var  img = document.getElementById('img');
    const ws = new WebSocket('ws://www.badtudou.com:8080');
    var token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjczY2YxNmZiNDMzMzNlMjlkMTk5NTY1OGRiZmNlZDQxYjQwZjBkOTllN2VmYmNhZDU0ZWE1ZmVkMDZjODk1YWQ4ODE3ODYxZWMxMDhjNGY4In0.eyJhdWQiOiIxIiwianRpIjoiNzNjZjE2ZmI0MzMzM2UyOWQxOTk1NjU4ZGJmY2VkNDFiNDBmMGQ5OWU3ZWZiY2FkNTRlYTVmZWQwNmM4OTVhZDg4MTc4NjFlYzEwOGM0ZjgiLCJpYXQiOjE1MjUxODkyOTcsIm5iZiI6MTUyNTE4OTI5NywiZXhwIjoxNTU2NzI1Mjk3LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.OlffP0BO-dnKRnoyObzaUit8yDpRMsZHxtizqG8QxjSKCfswOckBYcuBp8_1YFauaQ-Gaw5a_UE5vwBVtO73Yf8OhjZKU_c8AqTX9z9-lBVBB899U8I2UdQ8dMhs6j7gZr2thFmtvdsUQVmE2TxYeSpD6XY7yJtd0Q9Wa7A3KhISmFDilgl6wC4ashG1spOm8AfebdUgzqLMRxrBAo7O6LMDlGjjtjTRSvGZS56qhThUDxolnUi_oQ8BOIVUdFWIZd2gIaR9w73WCpEY4JaeJwn4Pje-MVrjKU-yhz0erpH5FUAHre5CmXX1nDa4LpHBps45cFF1LfQcAY8y-K367Q4QYbC8sanp2svVgDBpHWEAqYAHCi5YK-jY4o7_g4fX264PbVA9z2N9ZroTAxB1jmvGz4PInBM_qza7fYrH8LKx4oHsWDSoOBLZGVLculNrP1tktWehgB3HsXBvtbgLDQKFNXAQ3I0Tr8uWVcoApx-ZRhAxGTsX7k_MIkyPgq0lOqVqq9avOK1N5CUWywmtk9db--4dSpmu54Csi39swSV3OKGSMucoeJqCGHJbmtpeZnu_4LdBNvfpj1lGoqTAcLHbaORtTROIAfqlsNY6XF-VGHMFlXqj8SbSMFhJ8ODrDjXR28of8nC-wSoab46KzMLV5O24ei9L9LQ1449e-OI';

    // 认证
    function authentication(){
        sendData("authentication", token, null);
    }

    // 订阅
    function subscribe(channel){
        var data = {"channel":channel};
        sendData("subscribe", null, data);
    }

    // 退订
    function unsubscribe(channel){
        var data = {"channel":channel};
        sendData("unsubscribe", null, data);
    }

    // 发布
    function publish(channel, data)
    {
        var data = { "channel":channel,
                     "body":data
                };
        sendData("publish", null, data);
    }

    // 发送数据
    function sendData(action, toekn, data){
        var jsonData = {
            "action": action,
            "token": token,
            "data" : data
        };
        ws.send(JSON.stringify(jsonData));
    }


    

     ws.onopen = function (data) {
        authentication();
        console.log('申请认证');
       
    };

    ws.onmessage = function(event) {
        console.log(event);
        var resultJson = JSON.parse(event.data);
        switch(resultJson.action) {
            case 'authentication':
                if (resultJson.statusCode == 200) {
                    console.log('认证成功');
                    subscribe(1);

                }
            break;

            case 'subscribe':
                console.log('订阅');
                break;

            case 'broadcast':
                console.log('收到广播');
                img.src=resultJson.data;
                break;

        }
    };

</script>
</body>
</html>