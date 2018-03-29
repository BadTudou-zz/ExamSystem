<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑问题</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>问题类型</label>
          <div class="select">
            <select v-model="currentQuestionData.question_type">
              <option value="SINGLE_CHOICE">单选</option>
            </select>
          </div>
        </div>

        <div class="box-item">
          <label>问题难度</label>
          <div class="select">
            <select v-model="currentQuestionData.level_type">
              <option value="EASY">简单</option>
              <option value="HARD">困难</option>
            </select>
          </div>
        </div>

        <div class="box-item">
          <label>问题标题</label>
          <input v-model="currentQuestionData.title" class="input" type="text">
        </div>

        <div class="box-item">
          <label>问题内容</label>
          <textarea v-model="currentQuestionData.body" class="textarea" type="text"></textarea>
        </div>

        <div class="box-item">
          <label>答案</label>
          <textarea v-model="currentQuestionData.answer" class="textarea" type="number"></textarea>
        </div>

        <div class="box-item">
          <label>答案备注</label>
          <textarea v-model="currentQuestionData.answer_comment" class="textarea" type="text"></textarea>
        </div>

      </section>
     <footer class="modal-card-foot">
        <button @click="editQuestion()" class="button is-success">确认</button>
        <button @click="switchModal()" class="button">取消</button>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentQuestionData: {
        question_type: null,
        level_type: null,
        title: null,
        body: null,
        answer: null,
        answer_comment: null,
      },
      token: null,
      isShowModal: false,
    }
  },
  props: [
    'editData',
  ],
  components: {

  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    editQuestion: function () {
      const that = this;
      let id = that.editData.id;
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token,
        },
        params: {
          question_type: that.currentQuestionData.question_type,
          level_type: that.currentQuestionData.level_type,
          title: that.currentQuestionData.title,
          body: that.currentQuestionData.body,
          answer: that.currentQuestionData.answer,
          answer_comment: that.currentQuestionData.answer_comment
        }
      }).then(res => {
        alert('编辑成功');
        that.$emit('getQuestion');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  creatad() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.currentQuestionData.question_type = value.question_type;
      that.currentQuestionData.level_type = value.level_type;
      that.currentQuestionData.title = value.title;
      that.currentQuestionData.body = value.body;
      that.currentQuestionData.answer = value.answer;
      that.currentQuestionData.answer_comment = value.answer_comment;
    }
  }
}
</script>

<style>
</style>
