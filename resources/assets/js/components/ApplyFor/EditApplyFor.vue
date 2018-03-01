<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑申请</p>
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
        title: null,
        score: null,
        min: null,
        describe: null
      },
      token: null,
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
    editApplyFor: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          question_type: that.chapterData.question_type,
          level_type: that.chapterData.level_type,
          title: that.chapterData.title,
          body: that.chapterData.body,
          answer: that.chapterData.answer,
          answer_comment: that.chapterData.answer_comment
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
