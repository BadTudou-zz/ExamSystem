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
              <option disabled value="MULTIPLE_CHOICE">多选</option>
              <option disabled value="TRUE_FALSE">判断</option>
              <option disabled value="FILL_IN">填空</option>
              <option disabled value="SHORT_ANSWER">简答</option>
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
          <label>问题</label>
          <input v-model="currentQuestionData.title" class="input" type="text">
        </div>


        <!-- 单选、多选 -->
        <div class="box-item">
          <label>所给选项</label>
          <div class="options-box">
            <label>A.</label>
            <input v-model="options[0]" class="input" type="text">
          </div>
          <div class="options-box">
            <label>B.</label>
            <input v-model="options[1]" class="input" type="text">
          </div>
          <div class="options-box">
            <label>C.</label>
            <input v-model="options[2]" class="input" type="text">
          </div>
          <div class="options-box">
            <label>D.</label>
            <input v-model="options[3]" class="input" type="text">
          </div>
        </div>



        <!-- 正确答案 -->
        <div class="box-item">
          <label>正确答案</label>
          <div v-show="currentQuestionData.question_type ==='SINGLE_CHOICE'" class="select">
            <select v-model="currentQuestionData.answer">
              <option value='A'>A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
            </select>
          </div>

          <div v-show="currentQuestionData.question_type ==='MULTIPLE_CHOICE'">
            <input v-model="currentQuestionData.answer" class="input" type="text" placeholder="请用英文逗号将多个答案隔开">
          </div>
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
      options: [],
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
    clearWords: function () {
      const that = this;
      that.currentQuestionData.question_type = 'SINGLE_CHOICE';
      that.currentQuestionData.level_type = 'EASY';
      that.currentQuestionData.title = '';
      that.currentQuestionData.body = '';
      that.currentQuestionData.answer = '';
      that.currentQuestionData.answer_comment = '';

      that.options = [];
    },
    getAnswerOptions: function () {
      const that = this;
      let answer_body = '';
      for (let i = 0; i < that.options.length; i++) {
        if (i !== that.options.length - 1) {
          answer_body += that.options[i] + ' '
        }
        else {
          answer_body += that.options[i];
        }
      }
      return answer_body;
    },
    editQuestion: function () {
      const that = this;
      let id = that.editData.id;
      let body = that.getAnswerOptions();

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
          body: body,
          answer: that.currentQuestionData.answer,
          answer_comment: that.currentQuestionData.answer_comment
        }
      }).then(res => {
        alert('编辑成功');
        that.$emit('getQuestion');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.clearWords();
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

<style scoped>
.options-box {
  margin: 20px 0 15px 0;
}
.options-box label {
  display: inline-block;
  width: 30px;
}
.options-box input {
  width: 500px;
}
</style>
