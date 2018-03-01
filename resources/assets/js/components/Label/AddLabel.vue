<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加标签</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>标签题目</label>
          <input v-model="labelData.title" class="input" type="text" placeholder="请输入标签名">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addApplyFor()" class="button is-success">确认</button>
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
      labelData: {
        title: null,
        creator_id: null,
        updated_at: null,
        created_at: null,
        id: null,
      },
      token: null,
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addLabel: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/tags/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          title: that.labelData.title,
          creator_id: that.labelData.creator_id,
          updated_at: that.labelData.updated_at,
          created_at: that.labelData.created_at,
          id: that.labelData.id,
        }
      }).then(res => {
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {
    this.token = sessionStorage.getItem('token');
  }
}
</script>

<style>
</style>
