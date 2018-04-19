<!-- 单选 -->
<template lang="html">
  <div>

    <div v-show="showSingleChoice" class="message">
      <div  v-for="(item,index) in singleChoiceData" class="message box">
        <div class="notification">
          <div class="operate-box">
            <button @click="deleteQuestion(index)" class="delete"></button>
            <div @click="editQuestion(index)" class="edit-button"><i class="fas fa-edit"></i></div>
          </div>
          <p class="detail">        id：{{ item.id }}
            &nbsp;&nbsp;&nbsp;&nbsp; 类型： 单选
            &nbsp;&nbsp;&nbsp;&nbsp; 难度：{{ item.level_type }}
          </p>
          <div class="question">题目描述{{ item.title }}</div>
          <div class="question">选项：{{ getOptionsString(item.body) }}</div>
          <div class="options">正确答案：{{ item.answer }}</div>
          <p class="time">{{ GLOBAL.toTime(item.created_at) }}</p>
        </div>

        <div class="answer">
          作答：
          <div class="select">
            <select v-model="answers[index]" @change="selectChange(index)">
              <option value='A'>A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
            </select>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>

export default {
  data() {
    return {
       singleChoiceData: [],
       answers: [],
       answersJson: {},
       showSingleChoice: false,
    }
  },
  components: {
  },
  props: [
    'data'
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
    // answer json
    selectChange: function (index) {
      const that = this;
      let id = `"${that.data[index]['id']}"`;
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
      let questionId = that.singleChoiceData[index]['id'];

      that.$emit('deleteQuestion', null,questionId);  //第一个参数名为调用的方法名，第二个参数为需要传递的参数
    },
    editQuestion: function (index) {
      const that = this;
      let editData = that.singleChoiceData[index];
      that.$emit('editQuestion', null, editData);  //第一个参数名为调用的方法名，第二个参数为需要传递的参数
    },
    // 去重
    uniqData: function(value) {
      const that = this;
      let len = value.length;
      let uniqData = [];

      for (let i = 0; i < value.length; i++) {

        for (let j = 0; j < uniqData.length; j++) {
          if (uniqData[j]['id'] === value[i]['id']) {
            break;
          }
        }
        uniqData.push(value[i]);
      }
      return uniqData;
    },
  },
  computed: {
  },
  created() {

  },
  watch: {
    data: function (value, oldValue) {
      const that = this;
      that.singleChoiceData = that.uniqData(value);

      if (value.length !== 0) {
        that.showSingleChoice = true;
      }
      else {
        console.log('暂无数据')
      }
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
</style>
