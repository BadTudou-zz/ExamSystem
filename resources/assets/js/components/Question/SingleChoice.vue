<!-- 单选 -->
<template lang="html">
  <div class="box">

    <div class="message box">
      单选
      <!-- <div class="notification">
        <p class="question">        问题id：{{ item.id }}
          &nbsp;&nbsp;&nbsp;&nbsp; 问题题目：{{ item.title }}
          &nbsp;&nbsp;&nbsp;&nbsp; 问题类型：{{ item.question_type }}
          &nbsp;&nbsp;&nbsp;&nbsp; 难易程度：{{ item.level_type }}
        </p>
        {{ item.body }}
        <p class="time">{{item.created_at}}</p>
      </div>
      <div class="answer">
        <p>回复：{{ item.answer_comment }}</p>
      </div> -->
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
  props: [
    'item'
  ],
  methods: {
  },
  computed: {
  },
  created() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    item: function (value, oldValue) {
      const that = this;
      // debugger
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
.answer {
  margin-left: 50px;
}
</style>
