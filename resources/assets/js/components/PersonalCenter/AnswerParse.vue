<!-- 查看考试(进行) -->
<template lang="html">
  <div>

    <div>
      <div v-for="(item,index) in questionData">
        <div class="message">
          <div class="message box">
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
                    <input disabled class="answer-index" v-model="answer[item.id]" value="A" type="radio">{{ item.body.split('!')[0] }}
                  </div>
                  <div class="">
                    <input disabled class="answer-index" v-model="answer[item.id]" value="B" type="radio">{{ item.body.split('!')[1] }}
                  </div>
                  <div class="">
                    <input disabled class="answer-index" v-model="answer[item.id]" value="C" type="radio">{{ item.body.split('!')[2] }}
                  </div>
                  <div class="">
                    <input disabled class="answer-index" v-model="answer[item.id]" value="D" type="radio">{{ item.body.split('!')[3] }}
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
                    <input disabled class="answer-index" v-model="answer[item.id]" value="A" type="checkbox">{{ item.body.split('@')[0] }}
                  </div>
                  <div class="">
                    <input disabled class="answer-index" v-model="answer[item.id]" value="B" type="checkbox">{{ item.body.split('@')[1] }}
                  </div>
                  <div class="">
                    <input disabled class="answer-index" v-model="answer[item.id]" value="C" type="checkbox">{{ item.body.split('@')[2] }}
                  </div>
                  <div class="">
                    <input disabled class="answer-index" v-model="answer[item.id]" value="D" type="checkbox">{{ item.body.split('@')[3] }}
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
                    <input disabled v-model="answer[item.id]" value=false type="radio">错误
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
                <input disabled v-model="answer[item.id]" class="input" type="text" name="answer">
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
                <textarea disabled v-model="answer[item.id]" class="textarea" type="text"></textarea>
              </div>
            </div>

            <!-- <div class="parsing"> -->
              <!-- <p>我的答案：{{ item2.content }}</p>
              <p>参考答案：{{ items2.answer }} </p>
              <p>答案解析：{{ items2[index].status }}</p>
            </div> -->
            <div class="parsing">
              <p>我的答案：{{ parseJson[item.id].content }}</p>
              <p>参考答案：{{ parseJson[item.id].answer }} </p>
              <p>答案状态：{{ parseJson[item.id].status }}</p>
            </div>
          </div>

          <!-- parseJson -->

        </div>
      </div>

    </div>

  </div>
</template>

<script>
import moment from 'moment'

export default {
  data() {
    return {
       questionData: [],
       chapterIds: [],
       isLoading: true,
       questionIds: [],
       temporaryQuestionIds: [],  // 临时存储
       currentQuestionData: [],
       temporaryQuestionData: [], // 临时存储
       answer: [],
       loadingTime: 15,
       paperId: null,
       examineeAnswer: [],  // 考生的回答
       anserParseData: [],
       questionTypeData: [], // 问题类型数据
       separatorList: [],
       showParse: false,
       parseJson: {},
    }
  },
  components: {
  },
  props: [
    'testData',
    'scoreData',
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
    // 多选的答案格式
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

      setInterval(function(){
        that.loadingTime --;
      },1000)
    },
    // 根据Id排序数组
    sortArray: function (propertyName) {
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
    // 获取答案解析
    getAnserParse: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${that.examId}/check`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        this.anserParseData = res.data.data.results;
        that.parseJson  = that.getParseJson(this.anserParseData);
        debugger
        that.questionData = res.data.data.questions;
      }).catch(err => {
        alert('获取解析失败');
      })
    },
    divisionOptions: function (data) {
      const that = this;
      let options;
      if (data.includes('!')) options = data.split('!');
      if (data.includes('@')) options = data.split('@');

      return options;
    },
    // // 传入quesiton
    // getSingelOptions: function (data) {
    //   const that = this;
    //   let res = data.split('!');
    //
    // },
    // getMultiOPtions: function (data) {
    //   const that = this;
    //   let res = [];
    // },
    getQuestionType: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questionTypes`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.questionTypeData = res.data.data;
        for (let i = 0; i < that.questionTypeData.legnth; i++) {
          that.separatorList.push(that.questionTypeData[i]['delimiter']);
        }
        //
      }).catch(err => {
        console.log(err);
      })
    },

    getSeparate: function (data) {
      const that = this;
      let typeId = parseInt(data.type_id);
      let separate;
      for (let i = 0; i < that.questionTypeData.length; i++) {
        if (typeId === that.questionTypeData[i]['id']) {
          separate = that.questionTypeData[i]['delimiter'];
        }
      }
      return separate;
    },
    getParseJson: function (res) {
        let json = {};
        for (let i = 0; i < res.length; i++) {
            for (let j in res[i]) {
                // console.log(j);
                // console.log(res[i][j])
                let key = j;
                let value = res[i][j];
                json[key] = value;
            }
        }
        return json;
    }
  },
  computed: {
  },
  created() {
    this.getQuestionType();
  },
  watch: {
    testData: function (value, oldValue) {
      const that = this;
      that.examId = value.id;
      that.paperId = value.paper_id;
      that.getAnserParse();
    },
    questionData: function (value, oldValue) {
      const that = this;
      that.isLoading = false;
    },
  }
}
</script>

<style lang="scss" scoped>
.message {
  margin: 35px auto 0 auto;
  background-color: #f1faff;
}
.message {
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
.parsing {
  background-color: #d9f4ff;
  padding: 20px 15px;
  border-radius: 5px;
}
.is-false {
  color: red;
}
.is-true {
  color: green;
}
</style>
