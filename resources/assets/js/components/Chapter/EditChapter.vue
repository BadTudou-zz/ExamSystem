<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑章节</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>章节名称</label>
          <input v-model="currentChapterData.name" class="input" type="text" placeholder="请输入章节名">
        </div>
        <div class="box-item">
          <label>章节成绩</label>
          <input v-model="currentChapterData.score" class="input" type="number">
        </div>
        <div class="box-item">
          <label>章节数</label>
          <input v-model="currentChapterData.number" class="input" type="number">
        </div>
        <div class="box-item">
          <label>章节描述</label>
          <input v-model="currentChapterData.describe" class="input" type="text">
        </div>
        <div class="box-item">
          <div class="box-item">
            <label>题目类型</label>
            <div class="select">
              <select v-model="currentChapterData.question_type">
                <option value=0>单选</option>
                <option value=1>多选</option>
                <option value=2>判断</option>
                <option value=3>填空</option>
                <option value=4>简答</option>
              </select>
            </div>
          </div>

        </div>
        <div class="box-item">
          <label>涉及到的题目</label>
          <div class="all-question">

            <table class="table">
              <thead>
                <tr>
                  <th>是否选中</th>
                  <th>序号</th>
                  <th>类型</th>
                  <th>题目</th>
                  <th>分值</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in questionData">
                  <td v-show="item.question_type === currentChapterData.question_type"><input type="checkbox" v-bind:value="item.id" v-model="selectedQuesiton" class="question-seleted"></td>
                  <td v-show="item.question_type === currentChapterData.question_type">{{ item.id }}</td>
                  <td v-show="item.question_type === currentChapterData.question_type">{{ item.type_id }}</td>
                  <td v-show="item.question_type === currentChapterData.question_type">{{ item.title }}</td>
                  <td v-show="item.question_type === currentChapterData.question_type"><input v-model="questionScore[item.id]" type="number" class="input number-input"></input></td>
                </tr>
              </tbody>
            </table>

          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="editChapter()" class="button is-success">确认</button>
        <button @click="switchModal()" class="button">取消</button>
      </footer>
    </div>

  </div>
</template>
<script>
export default {
  data() {
    return {
      isShowModal: false,
      currentChapterData: {
        name: '',
        score: null,
        number: null,
        describe: '',
        question_type: '',
        scores: {},
      },
      questionsString: '',
      questionData: {},
      selectedQuesiton: [],
      editQuesitons: [],
      questionScore: [],
    }
  },
  components: {
  },
  props: [
    'editData',
    'examinationPaperId',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.currentChapterData.name = '';
      that.currentChapterData.score = '';
      that.currentChapterData.number = '';
      that.currentChapterData.describe = '';
      that.currentChapterData.question_type = '';
      that.selectedQuesiton = [];
      that.questionScore = [];
    },
    scoresJsonConvertsToArray: function (json) {
      let selectedQuestionIds = [];
      let scores = [];
      let res = [];

      for (i in json) {
        selectedQuestionIds.push(parseInt(i));
        scores.push(parseInt(json[i]));
      }

      for (let i = 0; i < selectedQuestionIds.length; i++) {
        res[selectedQuestionIds[i]] = scores[i];
      }
      that.selectedQuesiton = selectedQuestionIds;
      that.questionScore = res;
      // return res;
    },
    // 计算题目分值的JSON
    computedAnswerJson: function () {
      const that = this;
      let json = {};
      for (let i = 0; i < that.selectedQuesiton.length; i++) {
        json[that.selectedQuesiton[i]] = that.questionScore[that.selectedQuesiton[i]];
      }
      that.scoreJson = json;
      return json;
    },
    editChapter: function () {
      const that = this;
      let examinationPaperId = that.examinationPaperId;
      let questionsParams = this.GLOBAL.computedParams(that.selectedQuesiton, 'questions');
      let chapterId = that.editData.id;
      let scores = that.computedAnswerJson();

      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${examinationPaperId}/sections/${chapterId}?${questionsParams}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          name: that.currentChapterData.name,
          score: that.currentChapterData.score,
          number: that.currentChapterData.number,
          describe: that.currentChapterData.describe,
          question_type: that.currentChapterData.question_type,
          scores: scores,
        }
      }).then(res => {
        alert('编辑成功');
        that.clearWords()
        that.$emit('getChapter');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        console.log(err);
        that.clearWords();
        alert('编辑失败');
      })
    },
    getQuestion: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questions`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.questionData = res.data.data;
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    isSelectedQuesiton: function (id) {
      const that = this;
      let res = that.editQuesitons.includes(id);
      return res;
    }
  },
  creatad() {
  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      this.getQuestion();
      that.currentChapterData.name = value.name;
      that.currentChapterData.score = value.score;
      that.currentChapterData.number = value.number;
      that.currentChapterData.describe = value.describe;
      that.currentChapterData.question_type = value.question_type;

      that.currentChapterData.scores = value.scores;
      // that.scoresJsonConvertsToArray(value.scores);
    }
  }
}
</script>

<style scoped>
.question-seleted {
  width: 20px;
}
</style>
