<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑题目</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>题目类型</label>
          <div class="select">
            <select v-model="editQuestionData.type_id">
              <option value=1>单选</option>
              <option value=2>多选</option>
              <option value=3>判断</option>
              <option value=4>填空</option>
              <option value=5>简答</option>
            </select>
          </div>
        </div>
        <div class="box-item">
          <label>题目难度</label>
          <div class="select">
            <select v-model="editQuestionData.level_type">
              <option value="EASY">简单</option>
              <option value="MIDDLE">中等</option>
              <option value="HARD">困难</option>
            </select>
          </div>
        </div>

        <div class="box-item">
          <label>题目</label>
          <input v-model="editQuestionData.title" class="input" type="text">
        </div>


        <div class="box-item">
          <label>标签</label>
          <table class="table">
            <thead>
              <tr>
                <th>是否选中</th>
                <th>标签名</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item,index) in labelData">
                <td>
                  <input type="radio" v-bind:value="item.id" v-model="editQuestionData.tags" class="question-seleted">
                </td>
                <td>{{ item.title }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- 单选 -->
        <div v-show="parseInt(editQuestionData.type_id) === 1">
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
            <div class="control">
              <label class="radio single-choice"><input value="A" v-model="editQuestionData.answer" type="radio" name="answer">A</label>
              <label class="radio single-choice"><input value="B" v-model="editQuestionData.answer" type="radio" name="answer">B</label>
              <label class="radio single-choice"><input value="C" v-model="editQuestionData.answer" type="radio" name="answer">C</label>
              <label class="radio single-choice"><input value="D" v-model="editQuestionData.answer" type="radio" name="answer">D</label>
            </div>
          </div>
        </div>

        <!-- 多选 -->
        <div v-show="parseInt(editQuestionData.type_id) === 2">
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
            <label class="checkbox multiple-choice">
              <input v-model="editQuestionData.answer" value="A" type="checkbox">A
              <input v-model="editQuestionData.answer" value="B" type="checkbox">B
              <input v-model="editQuestionData.answer" value="C" type="checkbox">C
              <input v-model="editQuestionData.answer" value="D" type="checkbox">D
            </label>
          </div>
        </div>

        <!-- 判断 -->
        <div v-show="parseInt(editQuestionData.type_id) === 3">
          <!-- 正确答案 -->
          <div class="box-item">
            <label>正确答案</label>
            <div class="control">
              <label class="radio">
                <input v-model="editQuestionData.answer" value='true' type="radio">正确
              </label>
              <label class="radio">
                <input v-model="editQuestionData.answer" value='false' type="radio">错误
              </label>
            </div>
          </div>
        </div>


        <!-- 填空 -->
        <div v-show="parseInt(editQuestionData.type_id) === 4">
          <!-- 正确答案 -->
          <div class="box-item">
            <label>正确答案</label>
            <input v-model="editQuestionData.answer" class="input" type="text" name="answer">
          </div>
        </div>

        <!--简答-->
        <div v-show="parseInt(editQuestionData.type_id) === 5">
          <!-- 正确答案 -->
          <div class="box-item">
            <label>正确答案</label>
            <!-- <input v-model="editQuestionData.answer" class="input" type="text" name="answer"> -->
            <textarea v-model="editQuestionData.answer" class="textarea" name="name" rows="8" cols="80"></textarea>
          </div>
        </div>


        <div class="box-item">
          <label>答案解析</label>
          <textarea v-model="editQuestionData.answer_comment" class="textarea" type="text"></textarea>
        </div>

      </section>
     <footer class="modal-card-foot">
        <button @click="editQuesiton()" class="button is-success">确认</button>
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
      editQuestionData: {
        type_id: 1,
        level_type: 'EASY',
        title: '',
        body: '',
        answer: [],
        answer_comment: '',
        tags: '',
      },
      options: [],
      questionTypeData: {
        1: '!',
        2: '@'
      },
      labelData: [],
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
    clearWords: function () {
      const that = this;
      that.editQuestionData.type_id = 1;
      that.editQuestionData.level_type = 'EASY';
      that.editQuestionData.title = '';
      that.editQuestionData.body = '';
      that.editQuestionData.answer = [];
      that.editQuestionData.answer_comment = '';
      that.selectedLabel = '';

      that.options = [];
    },
    getAnswerOptions: function () {
      const that = this;
      let answer_body = '';
      for (let i = 0; i < that.options.length; i++) {
        if (i !== that.options.length - 1) {
          answer_body += that.options[i] + ','
        }
        else {
          answer_body += that.options[i];
        }
      }
      return answer_body;
    },
    getLabel: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/tags`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.labelData = res.data.data;
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
        if (err.response.status === 401) {
          // alert('登录超时');
          // location.reload();
        }
      })
    },
    editQuesiton: function () {
      const that = this;

      let body;
      // 单选或者多选
      if (parseInt(that.editQuestionData.type_id) === 1) {
        body = that.getAnswerOptions();  // 选项
      }
      // 多选
      else if (parseInt(that.editQuestionData.type_id) === 2) {
        if (that.editQuestionData.answer.length < 2) {
          alert('请至少选择两个答案')
          return;
        }
        body = that.getAnswerOptions();  // 选项

        that.editQuestionData.answer = that.editQuestionData.answer.join('')
      }
      else {
        body = '/';
      }

      let type_id = parseInt(that.editQuestionData.type_id);
      let level_type = that.editQuestionData.level_type;
      let title = that.editQuestionData.title;
      body =  body;  // 答案选项： 仅针对单选多选
      let answer = that.editQuestionData.answer;
      let answer_comment = that.editQuestionData.answer_comment;

      //

      if (!that.editQuestionData.type_id || !that.editQuestionData.level_type || !that.editQuestionData.title ||
          !that.editQuestionData.answer || !that.editQuestionData.answer_comment || !that.editQuestionData.tags)
      {
        alert('请检查内容是否填写完整');
        return;
      }

      // let tag = this.GLOBAL.computedParams(that.selectedLabel, 'tags');
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/${that.editData.id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          'tags[0]': that.editQuestionData.tags,
          type_id: that.editQuestionData.type_id,
          level_type: that.editQuestionData.level_type,
          title: that.editQuestionData.title,
          body: body,
          answer: that.editQuestionData.answer,
          answer_comment: that.editQuestionData.answer_comment,
        }
      }).then(res => {
        alert('编辑成功');
        that.$emit('getQuestion');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.clearWords();
        that.switchModal();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
      })
    }
  },
  created() {

  },
  watch: {
    'editQuestionData.type_id': function (value, oldValue) {
      const that = this;
      if (value === '2') {
        that.editQuestionData.answer = [];
      }
    },
    isShowModal: function (value, oldValue) {
      const that = this;
      if (value) {
        that.getLabel();
      }
    },
    editData: function (value, oldValue) {
      const that = this;

      that.editQuestionData.type_id =  value.type_id;
      that.editQuestionData.level_type =  value.level_type;
      that.editQuestionData.title =  value.title;
      that.editQuestionData.answer_comment =  value.answer_comment;
      that.editQuestionData.tags = value.tags;

      // 单选 body
      if (value.type_id === 1) {
        that.options =  value.body.split(',');
        that.editQuestionData.answer = value.answer;
      }
      // 多选
      else if (value.type_id === 2) {
        that.options =  value.body.split(',');
        that.editQuestionData.answer = value.answer.split('');
      }
      else {
        that.editQuestionData.answer =  value.answer;
        that.editQuestionData.body = '/';
      }
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
.single-choice {
  widows: 60px;
}
input {
  width: 60px;
}
.multiple-choice input {
  display: inline-block;
    width: 18px;
}
.control {
  display: inline-block;
}
</style>
