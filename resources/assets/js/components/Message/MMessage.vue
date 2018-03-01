<!-- 查看消息 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的消息">
        <button @click="searchMessage()" class="button" type="button" name="button">查找消息</button>
      </div>
        <button @click="addMessage()" class="button add-role-button" type="button" name="button">添加消息</button>
    </div>
    <div  v-for="item in messageData" class="message box">
      <div class="notification">
        <button @click="deleteMessage()" class="delete"></button>
        {{ item.data}}
        <p>{{item.created_at}}</p>
      </div>
    </div>

    <add-message ref="addMessage"></add-message>
  </div>
</template>

<script>
import AddMessage from './AddMessage'
export default {
  data() {
    return {
      messageData: [
        {
            "id": "456c152f-e3cb-4c58-a3f2-6809ffb5c05d",
            "from": "1",
            "to": "1",
            "data": "这是私信",
            "created_at": {
                "date": "2018-01-21 12:47:57.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            },
            "updated_at": {
                "date": "2018-01-21 12:47:57.000000",
                "timezone_type": 3,
                "timezone": "UTC"
            }
        }
      ],
      // messageData: null,
      isShowModal: false,
      messageId: null,
    }
  },
  components: {
    AddMessage,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteMessage: function () {
      const that = this;
      let prompt = confirm("确认删除改消息吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/messages/${that.messageId}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': that.token
          }
        }).then(res => {
          that.permissionData = res.data.data;
        }).catch(err => {
          console.log(err)
        })
      }
    },
    addMessage: function () {
      const that = this;
      that.$refs.addMessage.switchModal();
    },
    getMessage: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/messages/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.messageData = res.data.data;
      }).catch(err => {
        console.log(err)
      })
    },
    searchMessage: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/messages/${that.messageId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.messageData = [];
        that.messageData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
    // this.getMessage();
  },
  watch: {
  }
}
</script>

<style lang="scss">
.message {
  margin: 35px auto 0 auto;
}
.search-input {
  width: 200px;
  display: inline-block;
  margin-right: 10px;
}
.search-box {
  padding-right: 20px;
  display: inline-block;
  border-right: 1px solid #dedede;
}
.add-role-button {
  margin-left: 20px;
}
.box-item {
  margin-bottom: 20px;
  input  {
    display: inline-block;
    width: 300px;
  }
  label {
    display: inline-block;
    width: 130px;
  }
}
.notification p{
  margin-top: 25px;
  text-align: right;
}
</style>
