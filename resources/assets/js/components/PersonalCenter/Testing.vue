<!-- 查看考试(进行) -->
<template lang="html">
  <div>

    <div v-if="isLoading">
      <p class="wait-time">题目加载中，请稍等{{ time }}秒</p>
      <img class="loading" src="../../../img/loading.gif" alt="">
    </div>

    <div v-else>
      <button @click="submitAnswer()" class="button is-info finish-test" type="button" name="button">完成考试</button>


      <div v-for="(item,index) in questionData">
        <!-- 单选 -->
        <div class="message">
          <div v-show="item.question_type === 'SINGLE_CHOICE'" class="message box">
            <div class="notification">
              <p class="detail">        id：{{ item.id }}
                &nbsp;&nbsp;&nbsp;&nbsp; 类型： 单选
              </p>
              <div class="question">题目：{{ item.title }}</div>
              <div class="question">选项：{{ getOptionsString(item.body) }}</div>
              <!-- <div class="options">正确答案：{{ item.answer }}</div> -->
              <p class="time">{{ GLOBAL.toTime(item.created_at) }}</p>
            </div>
            <div class="answer">
              作答：
              <div class="select">
                <select v-model="answer[index]">
                  <option value='A'>A</option>
                  <option value="B">B</option>
                  <option value="C">C</option>
                  <option value="D">D</option>
                </select>
              </div>
            </div>
          </div>

          <!-- 多选 -->
          <div v-show="item.question_type === 'MULTIPLE_CHOICE'" class="message box">
            <div class="notification">
              <p class="detail">        id：{{ item.id }}
                &nbsp;&nbsp;&nbsp;&nbsp; 类型： 多选
              </p>
              <div class="question">题目：{{ item.title }}</div>
              <div class="question">选项：{{ getOptionsString(item.body) }}</div>
              <!-- <div class="options">正确答案：{{ item.answer }}</div> -->
              <p class="time">{{ GLOBAL.toTime(item.created_at) }}</p>
            </div>
            <div class="answer">
              作答：
              <input v-model="answer[index]" class="input answer-input" type="text">
              <!-- <label class="checkbox multiple-choice">
                <input v-model="answer[index]" value="A" type="checkbox">A
                <input v-model="answer[index]" value="B" type="checkbox">B
                <input v-model="answer[index]" value="C" type="checkbox">C
                <input v-model="answer[index]" value="D" type="checkbox">D
              </label> -->
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
</template>

<script>
import SingleChoice from '../Question/SingleChoice'

export default {
  data() {
    return {
       questionData: [],
       chapterIds: [],
       isLoading: true,
       singleChoiceAnswer: null,
       questionIds: [],
       temporaryQuestionIds: [],  // 临时存储
       currentQuestionData: [],
       temporaryQuestionData: [], // 临时存储
       answer: [],
       time: 15,
    }
  },
  components: {
    SingleChoice,
  },
  props: [
    'paperId',
    'examId',
  ],
  methods: {
    getChapterIds: function (paperId) {
      const that = this;
      let id = paperId;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        let chapterIds = res.data.data.sections;
        let chapterIdsArray = chapterIds.split(',')
        that.chapterIds = chapterIdsArray;
      }).catch(err => {
        console.log(err.message)
        alert('无相关试卷');

      })
    },
    clearQuestionIds: function () {
      const that = this;
      that.questionIds = [];
    },
    getQuestionIds: function (chapterId, totalLength, currentLength) {
      const that = this;
      let paperId = that.paperId;

      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${paperId}/sections/${chapterId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {

        let currentQuestionIds = res.data.data.questions;
        let currentQuestionIdsArray = currentQuestionIds.split(',');
        console.log('currentQuestionIds:')
        console.log(currentQuestionIdsArray)

        let array = that.temporaryQuestionIds.concat(currentQuestionIdsArray);
        that.temporaryQuestionIds = array;
      }).catch(err => {
        console.log(err)
      })
    },
    getQuestionData: function (questionId, totalLength, currentLength) {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/${questionId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        let currentQuestionData = res.data.data;
        that.temporaryQuestionData.push(currentQuestionData);

        // 用debugger的时候数据完全遍历到
        // if (currentLength + 1 === totalLength) {
        //   console.log('currentLength: ' + currentLength)
        //   console.log('totalLength: ' + totalLength)
        //   that.questionData = that.uniqData(that.temporaryQuestionData);
        // }
      }).catch(err => {
        // alert('查找出错');
        console.log(err);
      })
    },
    // 数组去重
    uniqArray: function (arr) {
      let uniq = [...new Set(arr)];
      return uniq;
    },
    quitTest: function () {
      const that = this;
    },
    submitAnswer: function () {
      const that = this;
      let id = that.examId;
      let answers = that.computedAnswerJson();
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/answer/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          'answers': answers
        }
      }).then(res => {
        console.log('答案提交成功');
        that.finishTest();
      }).catch(err => {
        let errMsg = err.response.data.error;
        if (errMsg) {
          console.log(errMsg);
        }
        else {
          console.log('答案提交失败');
        }
        console.log(err)
      })
    },
    // 完成考试
    finishTest: function () {
      const that = this;
      let id = that.examId;

      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/finish`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.$emit('switchTesting');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        alert('已结束');
      }).catch(err => {
        let errMsg = err.response.data.error;
        if (errMsg) {
          alert(errMsg);
        }
        else {
          alert('结束失败，请稍后再试');
        }
        console.log(err)
      })
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
    //
    computedAnswerJson: function () {
      const that = this;
      if (that.answer.length !== that.questionData.length) {
        alert('请检查是否全部作答');
        return;
      }

      let json = {};
      for (let i = 0; i < that.questionData.length; i++) {
        json[that.questionData[i].id] = that.answer[i];
      }
      return json;
    },
    waitTime: function () {
      const that = this;
      // 10s等待
      setInterval(function(){
        that.time--;
      },1000)
    },
    // 根据Id排序数组
    sortArray: function (propertyName){
      return function(object1,object2){
        var value1 = parseInt(object1.id);
        var value2 = parseInt(object2.id);

        if (value1 < value2) {
          return -1;
        }
        else if (value1 > value2) {
          return 1;
        }
        else{
          return 0;
        }
      }
    }
  },
  computed: {
  },
  created() {

  },
  watch: {
    paperId: function (value, oldValue) {
      const that = this;
      that.getChapterIds(value);
      that.clearQuestionIds();
    },
    chapterIds: async function (value, oldValue) {
      const that = this;
      console.log('获取章节ID')
      console.log(value)
      for (let i = 0; i < value.length; i++) {
        let response = await that.getQuestionIds(value[i])
      }
      that.waitTime();
      // 10s等待
      setTimeout(function(){
        console.log('加载题目id中....')
        console.log(that.temporaryQuestionIds);
        that.questionIds = that.temporaryQuestionIds;

      },10000)
    },
    // if get all questionIds
    questionIds: async function (value, oldValue) {
      const that = this;
      if (!value) return;

      for (let i = 0; i < value.length; i++) {
        let questionId = value[i];
        that.getQuestionData(questionId);
      }

      // 10s等待
      setTimeout(function(){
        console.log('加载题目中....')
        that.temporaryQuestionData = that.temporaryQuestionData.sort(that.sortArray());
        that.questionData = that.temporaryQuestionData;
        console.log(that.questionData);
      },15000)

    },
    questionData: function (value, oldValue) {
      const that = this;
      that.isLoading = false;
    }
  }
}
</script>

<style lang="scss">
.message {
  margin: 35px auto 0 auto;
  background-color: #fff;
}
.message {
  .notification {
    margin: 0;
    background-color: #fff;
  }
}
.notification .time{
  margin-top: 25px;
  text-align: right;
  padding-bottom: 20px;
  border-bottom: 1px solid #dedede;
}
.question {
  text-align: left;
  margin-bottom: 10px;
}
.loading {
  width: 50px;
  height: 50px;
  margin: 0 auto;
  display: block;
}
.finish-test {
  margin-left: 20px;
}
.multiple-choice {
  width: 200px;
}
.answer-input {
  display: inline-block;
  width: 300px;
}
.wait-time {
  text-align: center;
  margin-bottom: 20px;
}
</style>
