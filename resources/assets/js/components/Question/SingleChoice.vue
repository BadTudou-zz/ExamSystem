<!-- 单选 -->
<template lang="html">
  <div>

    <div class="message">
      <div  v-for="(item,index) in singleChoiceData" class="message box">
        <div class="notification">
          <p class="detail">        考试id：{{ item.id }}
            &nbsp;&nbsp;&nbsp;&nbsp; 考试类型： 单选
            &nbsp;&nbsp;&nbsp;&nbsp; 难易程度：{{ item.level_type }}
          </p>
          <div class="question">问题：{{ item.title }}</div>
          <div class="options">选项：{{ item.body }}</div>
          <p class="time">{{item.created_at}}</p>
        </div>
        <!-- <div>
          <p>备注：{{ item.answer_comment }}</p>
        </div> -->

        <div class="answer">
          答案：
          <!-- <input class="input" type="text" name="" value=""> -->
          <div class="control">
            <label class="radio">
              <input value="A" type="radio">A
            </label>
            <label class="radio">
              <input value="B" type="radio">B
            </label>
            <label class="radio">
              <input value="C" type="radio">C
            </label>
            <label class="radio">
              <input value="D" type="radio">D
            </label>
          </div>
        </div>
      </div>

    </div>

  </div>
</template>

<script>

export default {
  data() {
    return {
       token: null,
       singleChoiceData: [],
    }
  },
  components: {
  },
  props: [
    'item',
    // 'questionData',
    'currentQuestionData',
  ],
  methods: {
    filter: function (data) {
      const that = this;
      that.singleChoiceData = [];
      for (let i = 0; i < data.length; i++) {
        if (data[i].question_type === 'SINGLE_CHOICE') {
          that.singleChoiceData.push(data[i]);
          // console.log(data[i])
        }
      }
    },
    computedRadio: function (value) {
      const that = this;
      // if (value.indexOf("\n") > 0 ) {
      //   let a = '\n'
      //   return a;
      // }
      // else {
      //   return 0;
      // }

      if (value.indexOf("↵") > 0 ) {
        let a = '↵';
        return a;
      }
      else {
        return 0;
      }

    }
  },
  computed: {
  },
  created() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    // questionData: function (value, oldValue) {
    //   const that = this;
    //   that.filter(value);
    // },
    currentQuestionData: function (value, oldValue) {
      const that = this;
      // debugger
      that.filter(value);
    },
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
.detail {
  text-align: left;
  margin-bottom: 10px;
}
.answer {
  margin-top: 20px;
}
.answer input {
  width: 35px;
}
.options {
  margin-top: 30px;
}
</style>
