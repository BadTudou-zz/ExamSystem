<!-- 多选 -->
<template lang="html">
  <div>

    <div class="message">

      <div  v-for="(item,index) in multipleChoiceData" class="message box">
        <div class="notification">
          <div class="operate-box">
            <button @click="deleteQuestion(index)" class="delete"></button>
            <button @click="editQuestion(index)" class="button edit-question" type="button" name="button">编辑题目</button>
          </div>
          <p class="detail">        id：{{ item.id }}
            &nbsp;&nbsp;&nbsp;&nbsp; 类型： 多选
            &nbsp;&nbsp;&nbsp;&nbsp; 难度：{{ item.level_type }}
          </p>
          <div class="question">题目描述{{ item.title }}</div>
          <div class="question">选项：{{ item.body }}</div>
          <div class="options">正确答案：{{ item.answer }}</div>
          <p class="time">{{ GLOBAL.toTime(item.created_at) }}</p>
        </div>
        <!-- <div>
          <p>备注：{{ item.answer_comment }}</p>
        </div> -->

        <div class="answer">
          作答：
          <!-- <div class="select">
            <select v-model="answers[index]" @change="selectChange(index)">
              <option value='A'>A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
            </select>
          </div> -->
          <label class="checkbox multiple-choice">
            <input v-model="answers[index]"  type="checkbox">A
            <input v-model="answers[index]"  type="checkbox">B
            <input v-model="answers[index]"  type="checkbox">C
            <input v-model="answers[index]"  type="checkbox">D
          </label>
        </div>
      </div>

    </div>

  </div>
</template>

<script>

export default {
  data() {
    return {
       multipleChoiceData: [],
       answers: [],
       answersJson: {},
    }
  },
  components: {
  },
  props: [
    'item',
    // 'questionData',
    'currentQuestionData',
  ],
  methods: {
    getOptionsString: function (value) {
      const that = this;
      let arr = value.split(' ');
      let alphabet = ['A','B','C','D','E','F','G','H','I'];
      let str = '';
      for (let i = 0; i < arr.length; i++) {
        str += alphabet[i] + '.' + arr[i] + '   ';
      }
      return str;
    },
    // 筛选单选题目
    filter: function (data) {
      const that = this;
      that.multipleChoiceData = [];
      for (let i = 0; i < data.length; i++) {
        if (data[i].question_type === 'MULTIPLE_CHOICE') {
          that.multipleChoiceData.push(data[i]);
        }
      }
    },
    selectChange: function (index) {
      const that = this;
      let id = `"${that.currentQuestionData[index]['id']}"`;
      let answer = that.answers[index];
      that.answersJson[id] = answer;
      that.$emit('input', that.answersJson);  //第一个参数名为调用的方法名，第二个参数为需要传递的参数

      // console.log(that.answersJson)
    },
    computedRadio: function (value) {
      const that = this;
      if (value.indexOf("\n") > 0 ) {
        return "有";
      }
      else {
        return '无';
      }
    },
    deleteQuestion: function (index) {
      const that = this;
      console.log('删除多选');
      let questionId = that.multipleChoiceData[index]['id'];
      that.$emit('deleteQuestion', null, questionId);  //第一个参数名为调用的方法名，第二个参数为需要传递的参数
    },
    editQuestion: function (index) {
      const that = this;
      let editData = that.multipleChoiceData[index];
      that.$emit('editQuestion', null, editData);  //第一个参数名为调用的方法名，第二个参数为需要传递的参数
    }
  },
  computed: {
  },
  created() {

  },
  watch: {
    // questionData: function (value, oldValue) {
    //   const that = this;
    //   that.filter(value);
    // },
    currentQuestionData: function (value, oldValue) {
      const that = this;
      that.filter(value);
    },
    answers: function (value, oldValue) {
      const that = this;
    }
  }
}
</script>

<style lang="scss" scoped>
.message {
  margin: 35px auto 0 auto;
}
.message {
  .notification {
    margin: 0;
  }
}
.notification .time{
  margin-top: 25px;
  text-align: right;
  padding-bottom: 20px;
  border-bottom: 1px solid #dedede;
}
.detail {
  text-align: left;
  margin-bottom: 10px;
}
.answer {
  margin-top: 20px;
}
.answer input {
  width: 35px;
}
.options {
  margin-top: 30px;
}
.edit-question {
  float: right;
}
.operate-box {
  height: 40px;
  line-height: 40px;
}
.delete {
  float: right;
  margin-left: 20px;
}
.multiple-choice {
  width: 200px;
}
</style>
