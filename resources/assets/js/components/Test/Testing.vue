<!-- 查看考试(进行) -->
<template lang="html">
  <div class="box">

    <button class="button" type="button" name="button">退出考试</button>
    <button class="button is-primary" type="button" name="button">完成考试</button>

    <div  v-for="(item,index) in questionData" class="message box">
      <div class="notification">
        <p class="question">        考试id：{{ item.id }}
          &nbsp;&nbsp;&nbsp;&nbsp; 考试题目：{{ item.title }}
          &nbsp;&nbsp;&nbsp;&nbsp; 考试类型：{{ item.question_type }}
          &nbsp;&nbsp;&nbsp;&nbsp; 难易程度：{{ item.level_type }}
        </p>
        {{ item.body }}
        <p class="time">{{item.created_at}}</p>
      </div>
      <div>
        <p>回复：{{ item.answer_comment }}</p>
      </div>
    </div>

    <div v-show="isWaiting">
      <img src="" alt="">
    </div>

  </div>
</template>

<script>


export default {
  data() {
    return {
       questionData: [],
       token: null,
       chapterIds: [],
       questionIds: [],
       temporaryQuestionIds: [],
    }
  },
  components: {
  },
  props: [
    'paperId'
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
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${paperId}/sections/${chapterId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        let questionIds = res.data.data.questions;
        let questionIdsArray = questionIds.split(',')
        that.questionIds = that.questionIds.concat(questionIdsArray);

        for (let i = 0; i < questionIds.length; i++) {
          let questionId = questionIds[i];
          that.searchQuestion(questionId);
        }

      }).catch(err => {
        console.log(err)
      })
    },
    searchQuestion: function (questionId) {
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
      }).catch(err => {
        // alert('查找出错');
        console.log(err);
      })
    },
    // 数组去重
    uniqArray: function (arr) {
      let uniq = [...new Set(arr)];
      return uniq;
    }
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
    // questionIds: function (value, oldValue) {
    //   const that = this;
    //   for (let i = 0; i < value.length; i++) {
    //     let questionId = value[i];
    //     that.searchQuestion(questionId);
    //   }
    // },
    // questionData: function (value, oldValue) {
    //   const that = this;
    //   console.log('questionData数据变更');
    // }

  }
}
</script>

<style lang="scss">
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
.question {
  text-align: left;
  margin-bottom: 10px;
}
</style>
