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
              <option value="MULTIPLE_CHOICE">多选</option>
              <option value="TRUE_FALSE">判断</option>
              <option value="FILL_IN">填空</option>
              <option value="SHORT_ANSWER">简答</option>
            </select>
          </div>
        </div>
        <div class="box-item">
          <label>问题难度</label>
          <!-- ?? 枚举值有哪些 -->
          <div class="select">
            <select v-model="questionData.level_type">
              <option value="EASY">简单</option>
              <option value="HARD">困难</option>
            </select>
          </div>
        </div>

        <div class="box-item">
          <label>问题</label>
          <input v-model="questionData.title" class="input" type="text">
        </div>

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

        <div class="box-item">
          <label>正确答案</label>
          <div class="select">
            <select v-model="questionData.answer">
              <option value='A'>A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
            </select>
          </div>
        </div>

        <div class="box-item">
          <label>答案备注</label>
          <textarea v-model="questionData.answer_comment" class="textarea" type="text"></textarea>
        </div>

      </section>
     <footer class="modal-card-foot">
        <button @click="addQuestion()" class="button is-success">确认</button>
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
      options: [],
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.questionData.question_type = 'SINGLE_CHOICE';
      that.questionData.level_type = 'EASY';
      that.questionData.title = '';
      that.questionData.body = '';
      that.questionData.answer = '';
      that.questionData.answer_comment = '';

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
    addQuestion: function () {
      const that = this;

      let body = that.getAnswerOptions();

      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token,
        },
        params: {
          question_type: that.questionData.question_type,
          level_type: that.questionData.level_type,
          title: that.questionData.title,
          body: body,
          answer: that.questionData.answer,
          answer_comment: that.questionData.answer_comment,
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getQuestion');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.clearWords();
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    options: function (value, oldValue) {
      const that = this;
      // console.log(value)
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
