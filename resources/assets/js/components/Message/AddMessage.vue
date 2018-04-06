<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">发送消息</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>发送到</label>
          <input v-model="messageData.to" class="input" type="text" placeholder="需要发送消息的用户ID">
        </div>

        <div class="box-item">
          <label>消息内容</label>
          <textarea v-model="messageData.data" class="textarea" type="text"></textarea>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addMessage()" class="button is-success">确认发送</button>
        <button  @click="switchModal()" class="button">取消</button>
      </footer>
    </div>

  </div>
</template>
<script>
export default {
  data() {
    return {
      isShowModal: false,
      messageData: {
        to: null,
        data: null,
      }
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
      that.clearWords();
    },
    clearWords: function () {
      const that = this;
      that.messageData.to = '';
      that.messageData.data = '';
    },
    addMessage: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/messages/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': this.GLOBAL.token,
        },
        params: {
          to: that.messageData.to,
          data: that.messageData.data
        }
      }).then(res => {
        alert('发送成功');
        that.$emit('getMessage');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.clearWords();
      }).catch(err => {
        alert('发送失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {

  },
  watch: {
  }
}
</script>

<style>
</style>
