
<template lang="html">
  <!-- <div class="modal" v-bind:class="{'is-active': isShowModal}"> -->
  <div class="modal is-active">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">监控视频</p>
        <button @click="closeModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="booth">
          <!-- <video id="video" width="400" height="300"></video>
          <canvas class="hidden" id='canvas' width='400' height='300'></canvas> -->
          <img id='img' width="400" height="300" src={{ imgSrc }} >
        </div>

      </section>
      <footer class="modal-card-foot">
        <!-- <button class="button is-success">确认</button> -->
        <!-- <button  @click="switchModal()" class="button">取消</button> -->
        <button  @click="closeModal()" class="button">取消</button>
      </footer>
    </div>
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
      isShowModal: false,
      monitorUserId: '',
      imgSrc: '',
    };
  },
  components: {
  },
  props: [
    'currentUserId'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    // 认证
    authentication () {
      // debugger
      this.sendData("authentication", this.token, null);
    },
    // 订阅
    subscribe (channel) {
      // debugger
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
    closeWebSocket: function () {
      const that = this;
      that.ws = null;
      that.unsubscribe(that.currentUserId);
      ws.close();
    },
    onopen: function () {
      const that = this;
      ws.onopen = function (data) {
        that.authentication();
        console.log('教师端：申请认证');
      }();
    },
    closeModal: function () {
      const that = this
      that.closeWebSocket();
      // that.$emit('changeIsShowWeb');
      that.$emit('changeIsShowWeb');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
    }
  },
  created() {
    this.userId = sessionStorage.getItem('monitorUserId');
    this.token = sessionStorage.getItem('token').split(' ')[1];
    this.onopen();

    // ws.onmessage = function(event) {
    //   const that = this;
    //   debugger
    //   console.log(event);
    //   var resultJson = JSON.parse(event.data);
    //   switch(resultJson.action) {
    //     case 'authentication':
    //       if (resultJson.statusCode == 200) {
    //         console.log('认证成功');
    //         that.subscribe(sessionStorage.getItem('monitorUserId'));
    //             // this.subscribe(this.userId);
    //       }
    //       break;
    //     case 'subscribe':
    //       console.log('订阅');
    //       break;
    //     case 'broadcast':
    //       console.log('收到广播');
    //       img.src = resultJson.data;
    //       break;
    //   }
    // },
    ws.onmessage = function(event) {
      console.log(event);
      var resultJson = JSON.parse(event.data);
      switch(resultJson.action) {
        case 'authentication':
          if (resultJson.statusCode == 200) {
            console.log('认证成功');

            var data = { "channel": sessionStorage.getItem('monitorUserId') };
            var jsonData = {
              "action": 'subscribe',
              "token": sessionStorage.getItem('token').split(' ')[1],
              "data" : data,
            };
            var jsonString = JSON.stringify(jsonData);
            debugger
            //
            if (ws.readyState === 1) {
              ws.send(jsonString);
            }

            // subscribe(this.userId);
          }
          break;
        case 'subscribe':
          console.log('订阅');
          break;
        case 'broadcast':
          console.log('收到广播');
          this.imgSrc = resultJson.data.data;
          break;
      }
    };

  },
  watch: {
    // currentUserId: function (value, oldValue) {
    //   debugger
    //   const that = this;
    //   that.subscribe(value);
    // },
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
