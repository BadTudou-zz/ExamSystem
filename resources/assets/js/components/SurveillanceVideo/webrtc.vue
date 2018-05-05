<template>
  <div class="booth">
      <video id="video" width="200" height="200"></video>
      <canvas class="hidden" id='canvas' width='200' height='200'></canvas>
      <img class="hidden" id='img' src=''>
  </div>

</template>

<script>
// websocket
// const WebSocket = require('ws');
// import WebSocket from 'ws'
// import WebSocket from 'websocket'

const ws = new WebSocket('ws://www.badtudou.com:8080');
export default {
  data() {
    return {
      token: '',
    };
  },
  components: {
  },
  methods: {
    // 认证
    authentication () {
      // debugger
      this.sendData("authentication", this.token, null);
    },
    // 订阅
    subscribe (channel) {
      // debugger
      var data = {"channel":channel};
      this.sendData("subscribe", null, data);
    },
    // 退订
    unsubscribe (channel) {
      // debugger
      var data = {"channel":channel};
      this.sendData("unsubscribe", null, data);
    },
    // 发布
    publish (channel, data) {
      // debugger
      var data = {
        "channel":channel,
        "body":data
      };
      this.sendData("publish", null, data);
    },
    // 发送数据
    sendData(action, toekn, data) {
      // debugger
      var jsonData = {
        "action": action,
        "token": this.token,
        "data" : data
      };
      let jsonString = JSON.stringify(jsonData);
      // debugger
      ws.send(jsonString);
    },
    photograph () {
      // debugger
      //绘制canvas图形
      canvas.getContext('2d').drawImage(video, 0, 0, 400, 300);
      // debuggers

      //把canvas图像转为img图片
      //img.src = canvas.toDataURL("image/png");
      let base64Data = canvas.toDataURL("image/png");
      this.publish(1, base64Data);
      // var xhr = new XMLHttpRequest();
      // form = new  FormData();
      // form.append('postdata',base64Data);
      // xhr.open('POST','https://exam.gg/api/v1/webrtc',false);
      // xhr.send(form);
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    ws.onopen = function (data) {
      // debugger
      this.authentication();
      console.log('申请认证');
    };
    ws.onmessage = function(event) {
      // debugger
      console.log(event);
      var resultJson = JSON.parse(event.data);
      switch(resultJson.action) {
        case 'authentication':
        if (resultJson.statusCode == 200) {
          console.log('认证成功');
        }
        break;
      }
    };
    this.video = document.getElementById('video');
    this.canvas = document.getElementById('canvas');
    this.img = document.getElementById('img');
    const  photographTime = 50; // 单位毫秒
    // window对象路径 兼容手机
    var vendorUrl = window.URL || window.webkitURL;

    //媒体对象
    navigator.getMedia = navigator.getUserMedia ||
        navagator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;

    navigator.getMedia({
        video: true, //使用摄像头对象
        audio: false  //不适用音频
    }, function(strem){
        // debugger
        console.log(strem);
        video.src = vendorUrl.createObjectURL(strem);
        // debugger
        video.play();
    }, function(error) {
        //error.code
        console.log(error);
    });
    let clock = setInterval(this.photograph,photographTime);

  },
  watch: {
  }
}
</script>

<style scoped>
.booth {
    width: 200px;

    background:#ccc;
    border: 10px solid #ddd;
    margin: 0 auto;
}
.hidden {
  display: none;
}
</style>
