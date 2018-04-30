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
    var video = document.getElementById('video');
    var  canvas = document.getElementById('canvas');
    var  img = document.getElementById('img');
    const  photographTime = 1; // 单位毫秒
    // window对象路径 兼容手机
    vendorUrl = window.URL || window.webkitURL;

    //媒体对象
    navigator.getMedia = navigator.getUserMedia ||
        navagator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;


    navigator.getMedia({
        video: true, //使用摄像头对象
        audio: false  //不适用音频
    }, function(strem){
        console.log(strem);
        video.src = vendorUrl.createObjectURL(strem);
        video.play();
    }, function(error) {
        //error.code
        console.log(error);
    });

    clock =  window.setInterval(photograph,photographTime);

    function photograph(){
        //绘制canvas图形
        canvas.getContext('2d').drawImage(video, 0, 0, 400, 300);

        //把canvas图像转为img图片
        img.src = canvas.toDataURL("image/png");
        base64Data = canvas.toDataURL("image/png");

        var xhr = new XMLHttpRequest();
        form = new  FormData();
        form.append('postdata',base64Data);
        xhr.open('POST','https://exam.gg/api/v1/webrtc',false);
        xhr.send(form);
    }

</script>
</body>
</html>