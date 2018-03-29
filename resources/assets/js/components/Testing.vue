<!-- 查看考试 -->
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
      <div class="answer">
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
    }
  },
  components: {
  },
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
  },
  computed: {
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.getQuestion();
  },
  watch: {
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
.answer {
  margin-left: 50px;
}

</style>
