<template>
  <!-- <div class="booth">

      <video id="video" width="400" height="300"></video>
      <canvas id='canvas' width='400' height='300'></canvas>
      <img id='img' src=''>
  </div> -->

  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content user-content box">
      <div class="booth">

          <video id="video" width="400" height="300"></video>
          <canvas id='canvas' width='400' height='300'></canvas>
          <img id='img' src=''>
      </div>

    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>
  </div>

</template>

<script>
// websocket
// const WebSocket = require('ws');
// import WebSocket from 'ws'
// import WebSocket from 'websocket'

const ws = new WebSocket('wss://www.badtudou.com:8080');


export default {
  data() {
    return {
      token: '',
      isShowModal: false,
      userData: null,
    }
  },
  components: {
  },
  props: [
    'editData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    // 认证
    authentication: function () {
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
      var data = {
        "channel":channel,
        "body":data
      };
      this.sendData("publish", null, data);
    },
    // 发送数据
    sendData (action, toekn, data) {
      let jsonData = {
        "action": action,
        "token": this.token,
        "data" : data
      }
      ws.send(JSON.stringify(jsonData));
    },
    getUser: function () {
      const that = this;
      let id = that.editData.id;

      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/users`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.userData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    onOpen: function () {
      const that = this;
      ws.onopen = function (data) {
        that.authentication();
        console.log('申请认证');
      };
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');


    ws.onopen = function (data) {
    this.authentication();
      console.log('申请认证');
    }();
  },
  watch: {
    isShowModal: function (value, oldValue) {
      const that = this;
      if (value) {
        that.getUser();
      }
    },
    userData: function (value, oldValue) {
      const that = this;
      let userId;
      if (value) {
        for (let i = 0; i < value.length; i++) {
          userId = value[i]['id'];

          ws.onmessage = function(event) {
            debugger
            console.log(event);
            var resultJson = JSON.parse(event.data);
            switch(resultJson.action) {
              case 'authentication':
                if (resultJson.statusCode == 200) {
                  debugger
                    console.log('认证成功');
                    subscribe(userId);
                }
              break;
              case 'subscribe':
                console.log('订阅');
                break;
              case 'broadcast':
                console.log('收到广播');
                img.src = resultJson.data;
                break;
            }
          }(this);
        }
      }
    }
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

.user-box {
  width: 1250px;
}
.user-content {
  width: 1300px;
}
</style>
