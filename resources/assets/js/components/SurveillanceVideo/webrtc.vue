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
      userId: '',
    };
  },
  components: {
  },
  props: [
    // 'isLoading',
  ],
  methods: {
    // 认证
    authentication () {
      this.sendData("authentication", this.token, null);
    },
    // 订阅
    subscribe (channel) {
      //
      var data = {"channel":channel};
      this.sendData("subscribe", null, data);
    },
    // 退订
    unsubscribe (channel) {
      //
      var data = {"channel":channel};
      this.sendData("unsubscribe", null, data);
    },
    // 发布
    publish (channel, data) {
      //
      var data = {
        "channel":channel,
        "body":data
      };
      this.sendData("publish", null, data);
    },
    // 发送数据
    sendData(action, toekn, data) {
      //
      var jsonData = {
        "action": action,
        "token": this.token,
        "data" : data
      };

      let jsonString = JSON.stringify(jsonData);
      //
      ws.send(jsonString);
    },
    photograph () {
      //
      //绘制canvas图形
      canvas.getContext('2d').drawImage(video, 0, 0, 400, 300);
      //

      //把canvas图像转为img图片
      //img.src = canvas.toDataURL("image/png");
      let base64Data = canvas.toDataURL("image/png");
      let userId = sessionStorage.getItem('userId');
      this.publish(userId, base64Data);
      // var xhr = new XMLHttpRequest();
      // form = new  FormData();
      // form.append('postdata',base64Data);
      // xhr.open('POST','https://exam.gg/api/v1/webrtc',false);
      // xhr.send(form);
    },
    onopen: function () {
      const that = this;
      ws.onopen = function (data) {
        //
        that.authentication();
        console.log('学生端：申请认证');
      }();
    },
    closeWebSocket: function () {
      const that = this;
      that.unsubscribe(that.userId)
      ws.close();
    }
  },
  // ?? 离开页面取消订阅
  created() {
    this.token = sessionStorage.getItem('token').split(' ')[1];
    this.userId = sessionStorage.getItem('userId');

    this.onopen();
    ws.onmessage = function(event) {
      //
      console.log(event);
      var resultJson = JSON.parse(event.data);

      switch(resultJson.action) {
        case 'authentication':
        if (resultJson.statusCode == 200) {
          console.log('认证成功');
        }
        else {
          ws.close();
        }
        break;
      }
    };
    this.video = document.getElementById('video');
    this.canvas = document.getElementById('canvas');
    this.img = document.getElementById('img');
    const  photographTime = 100; // 单位毫秒
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
        //
        console.log(strem);
        video.src = vendorUrl.createObjectURL(strem);
        //
        video.play();
    }, function(error) {
        //error.code
        console.log(error);
    });
    let clock = setInterval(this.photograph,photographTime);

  },
  watch: {
    // isLoading: function (value, oldVale) {
    //   const that = this;
    //   debugger
    // }
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
