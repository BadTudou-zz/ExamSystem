<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加消息</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>发送到</label>
          <input v-model="messageData.to" class="input" type="text" placeholder="需要发送的用户ID">
        </div>

        <div class="box-item">
          <label>消息内容</label>
          <textarea v-model="messageData.data" class="textarea" type="text"></textarea>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="createMesaage()" class="button is-success">确认</button>
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
    },
    createMesaage: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/messages/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          to: that.messageData.to,
          data: that.messageData.data
        }
      }).then(res => {
      }).catch(err => {
        console.log(err)
      })

    }
  }
}
</script>

<style>
</style>
