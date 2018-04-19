<!-- 查看考试(进行) -->
<template lang="html">
  <div>

    <div v-if="isLoading">
      <img class="loading" src="../../../img/loading.gif" alt="">
    </div>

    <div v-else>
      <button @click="stopTest()" class="button is-info finish-test" type="button" name="button">结束考试</button>


      <single-choice ref="singleChoice"
                     v-bind:data="singleChoiceData"
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
       chapterIds: [],
       isLoading: true,
       singleChoiceAnwser: null,
       questionIds: [],
       temporaryQuestionIds: [],  // 临时存储
       currentQuestionData: [],
       temporaryQuestionData: [],  // 临时存储
       singleChoiceData: [],
       multipleChoiceData: [],
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
    // 通过章节ID数组找到所有章节下面的题目
    getQuestionIds: function (chapterId, totalLength, currentLength) {
      const that = this;
      let paperId = that.paperId;
      // console.log('getQuestionIds执行中')

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
        console.log(currentQuestionIds)
        that.temporaryQuestionIds.push(currentQuestionIdsArray);

        // 用debugger的时候数据完全遍历到
        if (currentLength + 1 === totalLength) {
          console.log('currentLength: ' + currentLength)
          console.log('totalLength: ' + totalLength)
          that.questionIds = that.temporaryQuestionIds;
        }
      }).catch(err => {
        console.log(err)
      })
    },
    getQuestionData: function (questionId, totalLength, currentLength) {
      const that = this;
      // console.log('getQuestionData执行中')

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
        if (currentLength + 1 === totalLength) {
          console.log('currentLength: ' + currentLength)
          console.log('totalLength: ' + totalLength)
          that.questionData = that.temporaryQuestionData;
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
          'Authorization': sessionStorage.getItem('token'),
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

      // console.log(that.singleChoiceAnwser)

      // alert('已结束');
      // axios({
      //   method: 'post',
      //   url: `${this.GLOBAL.localDomain}/api/v1/exams/${id}/stop`,
      //   headers: {
      //     'Accept': 'application/json',
      //     'Authorization': sessionStorage.getItem('token'),
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
    asyncGetQuestionIds: async function (value) {
      const that = this;
      let len = value.length;
      // console.log('执行asyncGetQuestionIds')

      for (let i = 0; i < len; i++) {
        let chapterId = value[i];
        // 获取所有题目的ID
        await that.getQuestionIds(chapterId, len, i);
      }
    },
    // 获取所有的题目的数据
    asyncGetQuestionData: async function (value) {
      const that = this;
      let len = value.length
      // console.log('执行asyncGetQuestionData')

      for (let i = 0; i < len; i++) {
        let questionId = value[i];
        await that.getQuestionData(questionId, len, i);
      }
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
    // 题目分类
    questionClassification: function (allQuestionData) {
      const that = this;
      // let data = that.uniqData(allQuestionData);
      let data = allQuestionData;
      for (let i = 0; i < data.length; i++) {

        switch (data[i]['question_type'] ) {
          case 'SINGLE_CHOICE':
            that.singleChoiceData.push(data[i]);
            break;
          case 'MULTIPLE_CHOICE':
            that.multipleChoiceData.push(data[i]);
            break;
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
      that.searchExaminationPaper(value);
    },
    chapterIds: function (value, oldValue) {
      const that = this;
      that.asyncGetQuestionIds(value);
    },
    // if get all questionIds
    questionIds: function (value, oldValue) {
      const that = this;
      if (value.length !== 0) {
        console.log('questionIds:-----')
        console.log(value)
      }
      that.asyncGetQuestionData(value);
    },
    questionData: function (value, oldValue) {
      const that = this;

      that.questionClassification(value);
      // if (that.singleChoiceData.length !== 0) {
        that.isLoading = false;
      // }
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
