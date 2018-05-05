<template>
  <div class="booth">

      <video id="video" width="400" height="300"></video>
      <canvas class="hidden" id='canvas' width='400' height='300'></canvas>
      <img class="hidden" id='img' src=''>
  </div>

</template>

<script>
// websocket
// const WebSocket = require('ws');
// import WebSocket from 'ws'
// import WebSocket from 'websocket'

// const ws = new WebSocket('wss://www.badtudou.com:8080');
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
      this.sendData("authentication", this.token, null);
    },
    // 订阅
    subscribe (channel) {
      let data = {"channel":channel};
      this.sendData("subscribe", null, data);
    },
    // 退订
    unsubscribe (channel) {
      let data = {"channel":channel};
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
      if (ws.readyState === 1) {
        ws.send(jsonString);
      }
    },
    onopen: function () {
      const that = this;
      ws.onopen = function (data) {
        that.authentication();
        console.log('申请认证');
      }();
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.onopen();
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
  },
  watch: {
  }
}
</script>

<style scoped>
.booth {
    width:400px;

    background:#ccc;
    border: 10px solid #ddd;
    margin: 0 auto;
}
.hidden {
  display: none;
}
</style>
