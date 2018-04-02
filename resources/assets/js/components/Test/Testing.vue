<!-- 查看考试(进行) -->
<template lang="html">
  <div>

    <div v-if="isLoading">
      <img class="loading" src="../../../img/loading.gif" alt="">
    </div>

    <div v-else>
      <button @click="stopTest()" class="button is-info finish-test" type="button" name="button">结束考试</button>

      <!-- <single-choice ref="singleChoice"
                     v-bind:question-data="questionData"
      ></single-choice> -->

      <single-choice ref="singleChoice"
                     v-bind:current-question-data="currentQuestionData"
                     v-model="singleChoiceAnwser"

      ></single-choice>

    </div>

  </div>
</template>

<script>
import SingleChoice from '../Question/SingleChoice'

export default {
  data() {
    return {
       questionData: [],
       token: null,
       chapterIds: [],
       questionIds: [],
       temporaryQuestionIds: [],
       isLoading: true,
       currentQuestionData: null,
       singleChoiceAnwser: null,
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
    searchExaminationPaper: function (paperId) {
      const that = this;
      let id = paperId;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
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
    searchChapter: function (chapterId) {
      const that = this;
      let paperId = that.paperId;
      let questionIdsArray = [];
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${paperId}/sections/${chapterId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {

        let questionIds = res.data.data.questions;
        questionIdsArray = questionIds.split(',')

        for (let i = 0; i < questionIdsArray.length; i++) {
          // if (questionIds[i] === ',') return;
          let questionId = questionIdsArray[i];
          that.searchQuestion(questionId, questionIdsArray.length, i);
        }

      }).catch(err => {
        console.log(err)
      })
    },
    searchQuestion: function (questionId, totalLength, currentLength) {
      const that = this;

      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/${questionId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        let currentQuestionId = res.data.data.id;
        that.questionData.push(res.data.data);

        if (totalLength === currentLength + 1) {
          that.isLoading = false;
          that.currentQuestionData = that.questionData;
        }

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
    mergeAnswerJson: function () {
      const that = this;
      var o1 = { a: 1 };
      var o2 = { b: 2 };
      var o3 = { c: 3, e: 4 };

      var obj = Object.assign(o1, o2, o3);
      console.log(obj); // { a: 1, b: 2, c: 3 }
      console.log(o1);  // { a: 1, b: 2, c: 3 }, 注意目标对象自身也会改变。
    },
    submitAnswer: function () {
      const that = this;
      let id = that.examId;
      let answers = '';
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/answer/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        data: {
          'answers': answers
        }
      }).then(res => {
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
    stopTest: function () {
      const that = this;
      let id = that.examId;

      console.log(that.singleChoiceAnwser)

      // alert('已结束');
      // axios({
      //   method: 'post',
      //   url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/stop`,
      //   headers: {
      //     'Accept': 'application/json',
      //     'Authorization': that.token
      //   }
      // }).then(res => {
      //   alert('已结束');
      // }).catch(err => {
      //   let errMsg = err.response.data.error;
      //   if (errMsg) {
      //     alert(errMsg);
      //   }
      //   else {
      //     alert('结束失败，请稍后再试');
      //   }
      //   console.log(err)
      // })
    },
  },
  computed: {
  },
  created() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    paperId: function (value, oldValue) {
      const that = this;
      that.searchExaminationPaper(value);
    },
    chapterIds: function (value, oldValue) {
      const that = this;
      for (let i = 0; i < value.length; i++) {
        let chapterId = value[i];
        that.searchChapter(chapterId);
      }
    },
    questionIds: function (value, oldValue) {
      const that = this;
      // console.log(value)
      // for (let i = 0; i < value.length; i++) {
      //   let questionId = value[i];
      //   that.searchQuestion(questionId);
      // }
    },
    singleChoiceAnwser: function (value, oldValue) {
      const that = this;
      console.log(value)
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
</style>
