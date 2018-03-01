<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加考试</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>题目</label>
          <input v-model="testData.title" class="input" type="text" placeholder="请输入考试名">
        </div>
        <div class="box-item">
          <label>数量</label>
          <input v-model="testData.number" class="input" type="text">
        </div>
        <div class="box-item">
          <label>类型</label>
          <input v-model="testData.exam_type" class="input" type="text">
        </div>
        <div class="box-item">
          <label>描述</label>
          <input v-model="testData.describe" class="input" type="text">
        </div>
        <div class="box-item">
          <label>成绩</label>
          <input v-model="testData.score" class="input" type="text">
        </div>
        <div class="box-item">
          <label>最小</label>
          <input v-model="testData.min" class="input" type="text">
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
      testData: {
        title: null,
        number: null,
        exam_type: null,
        describe: null,
        score: null,
        min: null,
        begin_at: null,
        paper_id: null
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
    addTest: function () {
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
