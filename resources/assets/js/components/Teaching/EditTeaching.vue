<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加授课</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>授课名称</label>
          <input class="input" type="text" placeholder="请输入授课名">
        </div>

        <div class="box-item">
          <label>授课名称</label>
          <input class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="editTeaching()" class="button is-success">确认</button>
        <button @click="switchModal()" class="button">取消</button>
      </footer>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      isShowModal: false,
      teachingData: {
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
    editTeaching: function () {
      const that = this;
      let id = that.teachingData.id;
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          to: that.teachingData.to,
          data: that.teachingData.data
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
