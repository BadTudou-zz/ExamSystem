<!-- 查看考试(进行) -->
<template lang="html">
  <div class="box">

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
  </div>
</template>

<script>


export default {
  data() {
    return {
       questionData: null,
       token: null,
       chapterIds: [],
       questionIds: [],
    }
  },
  components: {
  },
  props: [
    'paperId'
  ],
  methods: {
    getQuestion: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questions`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.questionData = res.data.data;
      }).catch(err => {
        console.log(err)
      })
    },
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
    searchChapter: function (chapterId) {
      const that = this;
      let paperId = that.paperId;
      let id = chapterId;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${paperId}/sections/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        debugger
        let questionIds = res.data.data.questions;
        let questionIdsArray = questionIds.split(',')
        that.questionIds.concat(questionIdsArray);
      }).catch(err => {
        console.log(err)
      })
    },
    searchQuestion: function () {
      const that = this;
      let id = that.searchKey;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.questionData = [];
        that.questionData.push(res.data.data)
        // that.questionData = res.data.data;
      }).catch(err => {
        alert('查找出错');
        that.getQuestion();
        console.log(err);
      })
    }
  },
  computed: {
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.getQuestion();
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
      console.log(that.questionIds)
    }

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
