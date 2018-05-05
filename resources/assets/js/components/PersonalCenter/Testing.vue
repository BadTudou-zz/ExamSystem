<!-- 查看考试(进行) -->
<template lang="html">
  <div>

    <div v-if="isLoading">
      <p class="wait-time">题目加载中，请稍等{{ loadingTime }}秒</p>
      <img class="loading" src="../../../img/loading.gif" alt="">
    </div>

    <div v-else>
      <h1>{{ testTitle }}</h1>

      <!-- <div v-if="!isLoading">
        <video class="box video-box" id="video" width="400" height="300"></video>
        <canvas class="hidden" id='canvas' width='400' height='300'></canvas>
        <img class="hidden" id='img' src=''>
        <webrtc></webrtc>
      </div> -->

      <webrtc v-if="isShowWebrtc"></webrtc>

      <button @click="submitAnswer()" class="button is-info finish-exam" type="button" name="button">完成考试</button>
      <div class="countdown">
        <!-- <i class="far fa-clock"></i> -->
        <!-- 考试剩余时间: {{ testRemainingTime }} -->
        <!-- 考试剩余时间: {{ toTime(testRemainingTime) }} -->

      </div>

      <div v-for="(item,index) in questionData">

        <div class="testing">

          <!-- 单选 -->
          <div v-show="item.type_id === 1" class="testing box">
            <div class="question-title">
              <!-- <span class="question-index"> {{ index + 1 }}</span> -->
              <span class="question-index"> {{ item.id }}</span>
              <span class="question-type">单选题</span>
              <span class="question-difficulty">难度：{{item.level_type}} </span>
            </div>
            <div class="triangle-topright">

            </div>
            <div class="test">
              <div class="question">题目：{{ item.title }}</div>
              <!-- <div class="question">选项：{{ getOptionsString(item.body) }}</div> -->
            </div>
            <div class="answer">
              <label class="checkbox">

                <!-- <input type="checkbox" v-bind:value="item.id" v-model="selectedUser" class="user-seleted"> -->
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="A" type="radio">{{ item.body[0] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="B" type="radio">{{ item.body[1] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="C" type="radio">{{ item.body[2] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="D" type="radio">{{ item.body[3] }}
                </div>
              </label>
            </div>
          </div>

          <!-- 多选 -->
          <div v-show="item.type_id === 2" class="testing box">
            <div class="question-title">
              <span class="question-index"> {{ item.id }}</span>
              <span class="question-type">多选题</span>
              <span class="question-difficulty">难度：{{item.level_type}} </span>
            </div>
            <div class="triangle-topright">

            </div>
            <div class="test">
              <div class="question">题目：{{ item.title }}</div>
            </div>

            <div class="answer">
              <label class="checkbox">
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="A" type="checkbox">{{ item.body[0] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="B" type="checkbox">{{ item.body[1] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="C" type="checkbox">{{ item.body[2] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="D" type="checkbox">{{ item.body[3] }}
                </div>
              </label>
            </div>
          </div>


          <!-- 判断 -->
          <div v-show="item.type_id === 3" class="testing box">
            <div class="question-title">
              <span class="question-index"> {{ item.id }}</span>
              <span class="question-type">判断题</span>
              <span class="question-difficulty">难度：{{item.level_type}} </span>
            </div>
            <div class="triangle-topright">

            </div>
            <div class="test">
              <div class="question">题目：{{ item.title }}</div>
            </div>

            <div class="answer">
              <div class="control">
                <label class="radio">
                  <input v-model="answer[item.id]" value=true type="radio">正确
                </label>
                <label class="radio">
                  <input v-model="answer[item.id]" value=false type="radio">错误
                </label>
              </div>
            </div>
          </div>

          <!-- 填空 -->
          <div v-show="item.type_id === 4" class="testing box">
            <div class="question-title">
              <span class="question-index"> {{ item.id }}</span>
              <span class="question-type">判断题</span>
              <span class="question-difficulty">难度：{{item.level_type}} </span>
            </div>
            <div class="triangle-topright">

            </div>
            <div class="test">
              <div class="question">题目：{{ item.title }}</div>
            </div>

            <div class="answer">
              <input v-model="answer[item.id]" class="input" type="text" name="answer">
            </div>
          </div>

          <!-- 简答 -->
          <div v-show="item.type_id === 5" class="testing box">
            <div class="question-title">
              <span class="question-index"> {{ item.id }}</span>
              <span class="question-type">判断题</span>
              <span class="question-difficulty">难度：{{item.level_type}} </span>
            </div>
            <div class="triangle-topright">

            </div>
            <div class="test">
              <div class="question">题目：{{ item.title }}</div>
            </div>

            <div class="answer">
              <textarea v-model="answer[item.id]" class="textarea" type="text"></textarea>
            </div>
          </div>

        </div>
      </div>

    </div>

  </div>
</template>

<script>
import SingleChoice from '../Question/SingleChoice'
import moment from 'moment'
import Webrtc from '../SurveillanceVideo/webrtc'

export default {
  data() {
    return {
       questionData: [],
       questionDataLength: null,
       chapterIds: [],
       isLoading: true,
       singleChoiceAnswer: null,
       questionIds: [],
       temporaryQuestionIds: [],  // 临时存储
       currentQuestionData: [],
       temporaryQuestionData: [], // 临时存储
       answer: [],
       loadingTime: 15,
       testRemainingTime: null,

       testTitle: '',
       paperId: null,
       examId: null,
       examTime: null,
       isShowWebrtc: false,
    }
  },
  components: {
    SingleChoice,
    Webrtc,
  },
  props: [
    'currentTestData',
  ],
  methods: {
    toTime: function (time) {
      return moment(time).format('HH:mm:ss');
    },
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
        },
      }).then(res => {
        let currentQuestionData = res.data.data;

        that.temporaryQuestionData.push(currentQuestionData);
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
    quit: function () {
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
        that.finish();
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
    finish: function () {
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

      // let arr = value.split(' ');
      // let arr = value;
      // let alphabet = ['A','B','C','D','E','F','G','H','I'];
      // let str = '';
      // for (let i = 0; i < arr.length; i++) {
      //   str += alphabet[i] + '.' + arr[i] + '\n';
      // }
      // return str.split('\n');
      // 
      return value.split(',')

    },
    computedAnswerJson: function () {
      const that = this;

      let json = {};
      let a = that.answer;
      for (let i = 0; i < that.questionData.length; i++) {
        let id = that.questionData[i].id;
        // if (that.answer[id].length > 1) {
        if (that.answer[id] instanceof Array) {
          that.answer[id] = that.answer[id].sort().join('')
        }
        json[id] = that.answer[id];
      }
      return json;
    },
    waitTime: function () {
      const that = this;

      setInterval(function(){
        that.loadingTime --;
      },1000)
    },
    countdown: function () {
      const that = this;
      setInterval(function(){
        that.testRemainingTime --;
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
    },
  },
  computed: {
  },
  created() {
  },
  watch: {
    currentTestData: function (value, oldValue) {
      const that = this;
      that.paperId = value.paper_id;
      that.examId = value.id;
      that.examTime = value.min;
      that.testTitle = value.title;
    },
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
        console.log('加载问题id中....')
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
      that.questionDataLength = value.length;
      that.isLoading = false;
      that.isShowWebrtc = true;
    },
    questionDataLength: function (value, oldValue) {
      const that = this;
      if (value !== oldValue) {
        for (let i = 0; i < that.questionData.length; i++) {
          let id = that.questionData[i]['id'];
          that.answer[id] = [];
        }
      }
    },
    examTime: function (value, oldValue) {
      const that = this;
      that.testRemainingTime = value * 60;
      that.countdown();
    }
  }
}
</script>

<style lang="scss" scoped>
.testing {
  margin: 35px auto 0 auto;
  background-color: #f1faff;
}
.testing {
  .test {
    margin: 0;
    padding: 0;
    background-color: #f1faff;
  }
}
.test .time{
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
.finish- {
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
.box {
  border: 2px dashed #00c4ff;
}
.question-title {
  width: 200px;
  height: 33px;
  line-height: 33px;
  border: 1px solid #538abd;
  color: #000;
  background-color: #f1faff;
  position: relative;
  top: -23px;
  left: -65px;
}
.question-index {
  display: inline-block;
  border-right: 1px solid #538abd;
  background-color: #00c4ff;
  color: #fff;
  padding: 0 10px;
  height: 100%;
}
.question-type {
  display: inline-block;
  border-right: 1px solid #538abd;
  padding: 0 11px 0 7px;
  height: 100%;
}
.question-difficulty {
  display: inline-block;
  height: 100%;
}
.triangle-topright {
  width: 0;
  height: 0;
  border-top: 15px solid #538abd;
  border-left: 15px solid transparent;
  position: relative;
  left: -65px;
  top: -23px;
}
.answer-index {
  margin: 0 12px 18px 0;
}
.countdown {
  display: inline-block;
}
.fa-clock {
  font-size: 30px;
  margin-right: 10px;
}
.finish-exam {
  float: right;
}
h1 {
  font-size: 25px;
  text-align: center;
}
vide {
  width: 200px;
  height: 200px;
}

</style>
