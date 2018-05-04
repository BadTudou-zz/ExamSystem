<template>
  <div class="booth">

      <video id="video" width="400" height="300"></video>
      <canvas id='canvas' width='400' height='300'></canvas>
      <img id='img' src=''>
  </div>

</template>

<script>
// websocket
// const WebSocket = require('ws');
// import WebSocket from 'ws'
// import WebSocket from 'websocket'

const ws = new WebSocket('wss://www.badtudou.com:8080');
const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjU5MzE5YjY2NjBiYmFlNTZlYzhjOTJlMDFkY2QwYmE4YzNlNTRjNzE5MWIxNDkzZDNlNzQxOWYwMTIyZGY2NWI5NmUyN2MzNDgxYmViMDQ0In0.eyJhdWQiOiIxIiwianRpIjoiNTkzMTliNjY2MGJiYWU1NmVjOGM5MmUwMWRjZDBiYThjM2U1NGM3MTkxYjE0OTNkM2U3NDE5ZjAxMjJkZjY1Yjk2ZTI3YzM0ODFiZWIwNDQiLCJpYXQiOjE1MjUxODkyNjAsIm5iZiI6MTUyNTE4OTI2MCwiZXhwIjoxNTU2NzI1MjYwLCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.fWKHped8kzl9yU1JxjsdqjW6aTO-oiU2BBwX3v_oGCk4PYTjscr0UqjshUIO7P_HbM3FJyokBGZ-Chn19PhzCaNR_0UQRZQ6ahtLSxXSL5r1HTfAyXLyyWwBjwFgWGDfyHxnn7px97UJ8jrnP-A2atTtfRhWxhac5BQpfIqhv3XfqVmo-E-zSzhoRWD0rzj-7YeC2dki02vAMM6fT2xB1mAVE1rmxjKstMZy9lx2686iOLx2LSNgVoRjzO_7nHK1kmF0NxKWd3zzaM7zJPocHZDMbR3N6oq3aFYzZulHmEy3HHyNBtqbbq_q8cSFhPt9VKHzhhx8NuYFhB3LASZM6rgKjZLOSucAMiJUqeJ7l7_DecQPwLQsiZd8_btHmIS3F6rLjH6IjKPk6XWQ25vsHH9QabTjSFgWh_nbwPxMMru9L0RcKRuqX9ncdLGoLt8f9z-sGGiTqZmSmbsrYACWB5xf1ac8kMug-FxuwMwle-xrDZiST93QCP6D53oUB2c5I9ettofBMb_WDM0uF4h_VCkak3bCx5kKt_eDOuKlAZbHLQbQs27ruwPHAMu7nwfSf7c9rm9JTtvbggbYNHuLIgo26GP5lLqoT3am2S90QRRpRY8E8ysHXzpNdzz2Xo2FkLIr9qVfN_ZTFz1_dwZz4xEiXGH_VnK4uEB-1g4fVtc';


export default {
  data() {
    return {
    };
  },
  components: {
  },
  methods: {
    // 认证
    authentication () {
      this.sendData("authentication", token, null);
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
      // debugger
      var data = {
        "channel":channel,
        "body":data
      };
      this.sendData("publish", null, data);
    },
    // // // 发布
    // publish (channel, data) {
    //   let data = {
    //     "channel": channel,
    //     "body": data
    //   }
    //   this.sendData("publish", null, data);
    // },
    // 发送数据
    sendData (action, toekn, data) {
      let jsonData = {
        "action": action,
        "token": token,
        "data" : data
      }
      ws.send(JSON.stringify(jsonData));
    }
  },
  created() {
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
   }
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
</style>
