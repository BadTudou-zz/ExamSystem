<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加问题</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>问题类型</label>
          <div class="select">
            <select v-model="questionData.question_type">
              <option value="SINGLE_CHOICE">单选</option>
            </select>
          </div>
        </div>
        <div class="box-item">
          <label>问题难度</label>
          <div class="select">
            <select v-model="questionData.level_type">
              <option value="EASY">简单</option>
              <option value="HARD">困难</option>
            </select>
          </div>
        </div>
        <div class="box-item">
          <label>问题标题</label>
          <input v-model="questionData.title" class="input" type="text">
        </div>

        <div class="box-item">
          <label>问题内容</label>
          <textarea v-model="questionData.body" class="textarea" type="text"></textarea>
        </div>
        <div class="box-item">
          <label>答案个数</label>
          <input v-model="questionData.answer" class="input" type="number">
        </div>
        <div class="box-item">
          <label>答案内容</label>
          <textarea v-model="questionData.answer_comment" class="textarea" type="text"></textarea>
        </div>
      </section>
     <footer class="modal-card-foot">
        <button class="button is-success">确认</button>
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
      questionData: {
        question_type: 'SINGLE_CHOICE',
        level_type: 'EASY',
        title: null,
        body: null,
        answer: null,
        answer_comment: null,
      },
      token: null,
    }
  },
  components: {
  },
  props: [
    'editData',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    editQuestion: function () {
      const that = this;
      let id = that.editData.id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          question_type: that.questionData.question_type,
          level_type: that.questionData.level_type,
          title: that.questionData.title,
          body: that.questionData.body,
          answer: that.questionData.answer,
          answer_comment: that.questionData.answer_comment
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
