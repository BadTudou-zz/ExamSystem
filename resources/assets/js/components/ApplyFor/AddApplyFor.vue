<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加申请</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>to</label>
          <input v-model="chapterData.to" class="input" type="text" placeholder="请输入申请名">
        </div>
        <div class="box-item">
          <label>resource_id</label>
          <input v-model="chapterData.resource_id" class="input" type="text">
        </div>
        <div class="box-item">
          <label>resource_type</label>
          <input v-model="chapterData.resource_type" class="input" type="text">
        </div>
        <div class="box-item">
          <label>data</label>
          <input v-model="chapterData.data" class="input" type="text">
        </div>
        <div class="box-item">
          <label>问题类型</label>
          <input v-model="chapterData.question_type" class="input" type="text">
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
      chapterData: {
        name: null,
        score: null,
        number: null,
        describe: null,
        question_type: null
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
    addChapter: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          to: that.applyForData.to,
          action: 'create',
          resource_id: that.applyForData.resource_id,
          resource_type: that.applyForData.type,
          data: that.applyForData.data
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
