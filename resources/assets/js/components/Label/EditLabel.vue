<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑标签</p>
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
          question_type: that.labelData.question_type,
          level_type: that.labelData.level_type,
          title: that.labelData.title,
          body: that.labelData.body,
          answer: that.labelData.answer,
          answer_comment: that.labelData.answer_comment
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
