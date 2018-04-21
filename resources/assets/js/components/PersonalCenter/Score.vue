<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">成绩详情</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
          <!-- <thead>
            <tr>
              <th></th>
              <th></th>
            </tr>
          </thead> -->
        <tbody>
          <tr>
            <td>试卷名</td>
            <td>{{ examTitle }}</td>
          </tr>
          <tr>
            <td>成绩</td>
            <td>{{ score }}  <button @click="answerParse()" class="button is-small answer-parse" type="button" name="button">查看答案解析</button> </td>
          </tr>
          </tbody>
        </table>

        <answer-parse ref="answerParse"
                      v-show="isShowAnswerParse"
                      v-bind:test-data="testData"
                      v-bind:score-data="scoreData"
        ></answer-parse>

      </section>
    </div>


  </div>
</template>

<script>
import AnswerParse from './AnswerParse'
export default {
  data() {
    return {
      isShowModal: false,
      score: '暂无考试成绩',
      isShowAnswerParse: false,
      paperId: null,
      testData: null,
      scoreData: null,
      examId: null,
      scoreData: null,
      examTitle: '',
    }
  },
  components: {
    AnswerParse,
  },
  props: [
    'selectedTestData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    answerParse: function () {
      const that = this;
      that.testData = that.selectedTestData;
      that.isShowAnswerParse = true;
    },
    getScore: function () {
      const that = this;
      console.log('查询成绩');
      let examId = that.examId;
      let score = '';
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/${examId}/score`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.scoreData = res.data;
        that.score = res.data.score;
      }).catch(err => {
        console.log(err);
      })
    },

  },
  computed: {
  },
  created() {
  },
  watch: {
    selectedTestData: function (value, oldValue) {
      const that = this;
      that.examId = value.id;
      that.examTitle = value.title;
      that.getScore();
    }
  }
}
</script>

<style scoped>
.answer-parse {
    background-color: #ffd530;
    margin-left: 40px;
}
.modal-card {
  width: 1000px;
}
</style>
