<!-- 查看消息 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的消息">
        <button class="button" type="button" name="button">查找消息</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加消息</button>
    </div>
    <div  v-for="item in data" class="message box">
      <div class="notification">
        <button class="delete"></button>
        {{ item.data}}
        <p>{{item.created_at}}</p>
      </div>
    </div>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加消息</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>发送到</label>
            <input class="input" type="text" placeholder="需要发送的用户名">
          </div>

          <div class="box-item">
            <label>消息内容</label>
            <textarea class="textarea" type="text"></textarea>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success">确认</button>
          <button  @click="showModal()" class="button">取消</button>
        </footer>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      "data": [
          {
              "id": "174d155f-b469-460f-8776-933032ab436e",
              "type": "App\\Notifications\\PrivateMessage",
              "notifiable_id": "1",
              "notifiable_type": "App\\User",
              "data": "{\"notifiable_id\":null,\"data\":\"\\u8fd9\\u662f\\u79c1\\u4fe1\"}",
              "read_at": null,
              "created_at": "2018-01-21 12:30:53",
              "updated_at": "2018-01-21 12:30:53"
          },
          {
              "id": "174d155f-b469-460f-8776-933032ab436e",
              "type": "App\\Notifications\\PrivateMessage",
              "notifiable_id": "1",
              "notifiable_type": "App\\User",
              "data": "{\"notifiable_id\":null,\"data\":\"\\u8fd9\\u662f\\u79c1\\u4fe1\"}",
              "read_at": null,
              "created_at": "2018-01-21 12:30:53",
              "updated_at": "2018-01-21 12:30:53"
          }
       ],
      isShowModal: false,
    }
  },
  components: {
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteRole: function () {
      const that = this;
      let prompt = confirm("确认删除改消息吗？");
      if (prompt) {

      }
    }
  },
  created() {
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
