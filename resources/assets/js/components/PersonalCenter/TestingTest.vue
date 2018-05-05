<!-- 查看考试(进行) 测试文件-->
<template lang="html">
  <div class="box">
    <div>
      <h1>{{ testTitle }}</h1>

      <video class="box video-box" id="video" width="400" height="300"></video>
      <canvas class="hidden" id='canvas' width='400' height='300'></canvas>
      <img class="hidden" id='img' src=''>

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
              <span class="question-index"> id:{{ item.id }}</span>
              <span class="question-type">单选题</span>
              <span class="question-difficulty">{{item.level_type}} </span>
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
                  <input class="answer-index" v-model="answer[item.id]" value="A" type="radio">{{ getOptionsString(item.body)[0] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="B" type="radio">{{ getOptionsString(item.body)[1] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="C" type="radio">{{ getOptionsString(item.body)[2] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="D" type="radio">{{ getOptionsString(item.body)[3] }}
                </div>
              </label>
            </div>
          </div>

          <!-- 多选 -->
          <div v-show="item.type_id === 2" class="testing box">
            <div class="question-title">
              <!-- <span class="question-index"> {{ index + 1 }}</span> -->
              <span class="question-index"> id:{{ item.id }}</span>
              <span class="question-type">多选题</span>
              <span class="question-difficulty">{{item.level_type}} </span>
            </div>
            <div class="triangle-topright">

            </div>
            <div class="test">
              <div class="question">题目：{{ item.title }}</div>
            </div>
            <div class="answer">
              <label class="checkbox">
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="A" type="checkbox">{{ getOptionsString(item.body)[0] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="B" type="checkbox">{{ getOptionsString(item.body)[1] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="C" type="checkbox">{{ getOptionsString(item.body)[2] }}
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value="D" type="checkbox">{{ getOptionsString(item.body)[3] }}
                </div>
              </label>
            </div>
          </div>

          <!-- 判断 -->
          <div v-show="item.type_id === 3" class="testing box">
            <div class="question-title">
              <!-- <span class="question-index"> {{ index + 1 }}</span> -->
              <span class="question-index"> id:{{ item.id }}</span>
              <span class="question-type">判断题</span>
              <span class="question-difficulty">{{item.level_type}} </span>
            </div>
            <div class="triangle-topright">

            </div>
            <div class="test">
              <div class="question">题目：{{ item.title }}</div>
            </div>
            <div class="answer">
              <label class="checkbox">
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value=1 type="checkbox">正确
                </div>
                <div class="">
                  <input class="answer-index" v-model="answer[item.id]" value=0 type="checkbox">错误
                </div>
              </label>
            </div>
          </div>


          <!-- 填空 -->
          <div v-show="item.type_id === 3" class="testing box">
            <div class="question-title">
              <!-- <span class="question-index"> {{ index + 1 }}</span> -->
              <span class="question-index"> id:{{ item.id }}</span>
              <span class="question-type">填空题</span>
              <span class="question-difficulty">{{item.level_type}} </span>
            </div>
            <div class="triangle-topright">

            </div>
            <div class="test">
              <div class="question">题目：{{ item.title }}</div>
            </div>
            <div class="answer">
              作答框：<input v-model="answer[item.id]" class="answer-input input" type="text">
            </div>
          </div>

          <!-- 简答 -->
          <div v-show="item.type_id === 3" class="testing box">
            <div class="question-title">
              <!-- <span class="question-index"> {{ index + 1 }}</span> -->
              <span class="question-index"> id:{{ item.id }}</span>
              <span class="question-type">简答题</span>
              <span class="question-difficulty">{{item.level_type}} </span>
            </div>
            <div class="triangle-topright">

            </div>
            <div class="test">
              <div class="question">题目：{{ item.title }}</div>
            </div>
            <div class="answer">
              作答框：<textarea v-model="answer[item.id]" class="answer-textarea textarea" name="name" rows="8" cols="80"></textarea>
            </div>
          </div>


        </div>
      </div>

    </div>

  </div>
</template>

<script>

// const ws = new WebSocket('wss://www.badtudou.com:8080')

import SingleChoice from '../Question/SingleChoice'
import moment from 'moment'

export default {
  data() {
    return {
       questionData: [],
       questionData: [{
            "id": 2,
            "type_id": 1,
            "tags": "0",
            "level_type": "EASY",
            "title": "2+2=???",
            "body": "1!2!3!4",
            "answer": "D",
            "answer_comment": "ddddddd",
            "created_at": "2018-04-29 19:31:06",
            "updated_at": "2018-04-29 19:31:06"
        }, {
            "id": 3,
            "type_id": 1,
            "tags": "0",
            "level_type": "EASY",
            "title": "1+1=?",
            "body": "1!2!3!4",
            "answer": "B",
            "answer_comment": "22",
            "created_at": "2018-04-29 19:36:51",
            "updated_at": "2018-04-29 19:36:51"
        }, {
            "id": 4,
            "type_id": 1,
            "tags": "0",
            "level_type": "EASY",
            "title": "1+1\u7b49\u4e8e\u591a\u5c11\uff1f",
            "body": "1!2!3!4",
            "answer": "1",
            "answer_comment": "\u6ca1\u6709",
            "created_at": "2018-04-29 19:44:35",
            "updated_at": "2018-04-29 19:44:35"
        }, {
            "id": 5,
            "type_id": 1,
            "tags": "0",
            "level_type": "MIDDLE",
            "title": "1+1\u7b49\u4e8e\u591a\u5c11\uff1f",
            "body": "1!2!3!4",
            "answer": "1",
            "answer_comment": "\u6ca1\u6709",
            "created_at": "2018-04-29 19:44:35",
            "updated_at": "2018-04-29 19:44:35"
        }, {
            "id": 6,
            "type_id": 1,
            "tags": "0",
            "level_type": "HARD",
            "title": "1+1\u7b49\u4e8e\u591a\u5c11\uff1f",
            "body": "1!2!3!4",
            "answer": "1",
            "answer_comment": "\u6ca1\u6709",
            "created_at": "2018-04-29 19:44:35",
            "updated_at": "2018-04-29 19:44:35"
        }, {
            "id": 7,
            "type_id": 3,
            "tags": "0",
            "level_type": "EASY",
            "title": "1+1\u7b49\u4e8e\u591a\u5c11\uff1f",
            "body": "1#2#3#4",
            "answer": "1",
            "answer_comment": "\u6ca1\u6709",
            "created_at": "2018-04-29 20:05:54",
            "updated_at": "2018-04-29 20:05:54"
        }, {
            "id": 8,
            "type_id": 4,
            "tags": "0",
            "level_type": "MIDDLE",
            "title": "1+1\u7b49\u4e8e\u591a\u5c11\uff1f",
            "body": "1$2$3$4",
            "answer": "1",
            "answer_comment": "\u6ca1\u6709",
            "created_at": "2018-04-29 20:05:54",
            "updated_at": "2018-04-29 20:05:54"
        }, {
            "id": 9,
            "type_id": 2,
            "tags": "0",
            "level_type": "HARD",
            "title": "1+1\u7b49\u4e8e\u591a\u5c11\uff1f",
            "body": "1@2@3@4",
            "answer": "1",
            "answer_comment": "\u6ca1\u6709",
            "created_at": "2018-04-29 20:05:54",
            "updated_at": "2018-04-29 20:05:54"
        }, {
            "id": 10,
            "type_id": 1,
            "tags": "0",
            "level_type": "HARD",
            "title": "1+1\u7b49\u4e8e\u591a\u5c11\uff1f",
            "body": "1!2!3!4",
            "answer": "xxx",
            "answer_comment": "xxx",
            "created_at": "2018-04-29 20:05:54",
            "updated_at": "2018-04-29 20:05:54"
        }, {
            "id": 11,
            "type_id": 5,
            "tags": "0",
            "level_type": "HARD",
            "title": "1+1\u7b49\u4e8e\u591a\u5c11\uff1f",
            "body": "1%2%3%4",
            "answer": "xxx",
            "answer_comment": "xxx",
            "created_at": "2018-04-29 20:05:54",
            "updated_at": "2018-04-29 20:05:54"
        }],
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
    }
  },
  components: {
    SingleChoice,
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
        }
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
    computedSeparator: function (value) {
      const that = this;
      // 单选题! 多选题@ 判断题# 填空题$ 简答题%
      let separator = '';

      // 单选
      if (value.includes('!')) {
        separator = '!';
      }
      // 多选
      else if (value.includes('@')) {
        separator = '@';
      }
      // 判断
      else if (value.includes('#')) {
        separator = '#';
      }
      // 填空
      else if (value.includes('$')) {
        separator = '$';
      }
      // 填空
      else if (value.includes('%')) {
        separator = '%';
      }

      return separator;
    },
    getOptionsString: function (value) {
      const that = this;
      let separator = that.computedSeparator(value);

      let arr = value.split(separator);
      let alphabet = ['A','B','C','D','E','F','G','H','I'];
      let str = '';
      for (let i = 0; i < arr.length; i++) {
        str += alphabet[i] + '.' + arr[i] + '\n';
      }
      return str.split('\n');
    },
    // ?? 多选的答案格式
    computedAnswerJson: function () {
      const that = this;
      // if (that.answer.length !== that.questionData.length) {
      //   alert('请检查是否全部作答');
      //   return;
      // }

      let json = {};
      for (let i = 0; i < that.questionData.length; i++) {
        json[that.questionData[i].id] = that.answer[i];
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
    expansionAnswerArray: function () {
      const that = this;
      let value = that.questionData;
      for (let i = 0; i < value.length; i++) {
        that.answer[value[i]['id']] = [];
      }
    },
    // 视频监控
    // 认证
    authentication () {
      // debugger
      this.sendData("authentication", sessionStorage.getItem('token'), null);
    },
    // 订阅
    subscribe (channel) {
      // debugger
      var data = {"channel":channel};
      this.sendData("subscribe", null, data);
    },
    // 退订
    unsubscribe (channel) {
      // debugger
      var data = {"channel":channel};
      this.sendData("unsubscribe", null, data);
    },
    // 发布
    publish (channel, data) {
      // debugger
      var data = {
        "channel":channel,
        "body":data
      };
      this.sendData("publish", null, data);
    },
    // 发送数据
    sendData(action, toekn, data) {
      // debugger
      var jsonData = {
        "action": action,
        "token": sessionStorage.getItem('token'),
        "data" : data
      };
      let jsonString = JSON.stringify(jsonData);
      // debugger
      ws.send(jsonString);
    },
    photograph () {
      // debugger
      //绘制canvas图形
      canvas.getContext('2d').drawImage(video, 0, 0, 400, 300);
      // debugger

      //把canvas图像转为img图片
      //img.src = canvas.toDataURL("image/png");
      let base64Data = canvas.toDataURL("image/png", 0.5);
      this.publish(1, base64Data);
      // var xhr = new XMLHttpRequest();
      // form = new  FormData();
      // form.append('postdata',base64Data);
      // xhr.open('POST','https://exam.gg/api/v1/webrtc',false);
      // xhr.send(form);
    }
  },
  computed: {
  },
  created() {
    this.expansionAnswerArray();
    ws.onopen = function (data) {
      // debugger
      this.authentication();
      console.log('申请认证');
    };
    ws.onmessage = function(event) {
      // debugger
      console.log(event);
      var resultJson = JSON.parse(event.data);
      switch(resultJson.action) {
        case 'authentication':
        if (resultJson.statusCode == 200) {
          console.log('认证成功');
        }
        break;
      }
    };
    this.video = document.getElementById('video');
    this.canvas = document.getElementById('canvas');
    this.img = document.getElementById('img');
    const  photographTime = 50; // 单位毫秒
    // window对象路径 兼容手机
    var vendorUrl = window.URL || window.webkitURL;

    //媒体对象
    navigator.getMedia = navigator.getUserMedia ||
        navagator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;

    navigator.getMedia({
        video: true, //使用摄像头对象
        audio: false  //不适用音频
    }, function(strem){
        // debugger
        console.log(strem);
        video.src = vendorUrl.createObjectURL(strem);
        // debugger
        video.play();
    }, function(error) {
        //error.code
        console.log(error);
    });
    let clock = setInterval(this.photograph,photographTime);

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
      that.isLoading = false;
    },
    examTime: function (value, oldValue) {
      const that = this;
      that.testRemainingTime = value * 60; //
      that.countdown();
    },
    answer: function (value, oldValue) {
      const that = this;
      console.log(that.computedAnswerJson())
    },
    questionData: function (value, oldValue) {
      const that = this;
      if (value.length === 0) return;
      that.expansionAnswerArray();
    },



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
.answer-input {
  width: 450px;
}
.video-box {
  width: 99px;
  height: 75px;
  display: inline-block;
  padding: 0;
  border: none;
}
.hidden {
  display: none;
}
</style>
