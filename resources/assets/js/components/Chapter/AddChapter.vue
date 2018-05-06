<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加章节</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>章节名称</label>
          <input v-model="chapterData.name" class="input" type="text" placeholder="请输入章节名">
        </div>
        <div class="box-item">
          <label>章节成绩</label>
          <input v-model="chapterData.score" class="input" type="number">
        </div>
        <div class="box-item">
          <label>题目数</label>
          <input v-model="chapterData.number" class="input" type="number">
        </div>
        <div class="box-item">
          <label>章节描述</label>
          <input v-model="chapterData.describe" class="input" type="text">
        </div>
        <div class="box-item">
          <label>题目类型</label>
          <div class="select">
            <select v-model="chapterData.question_type">
              <option value=1>单选</option>
              <option value=2>多选</option>
              <option value=3>判断</option>
              <option value=4>填空</option>
              <option value=5>简答</option>
            </select>
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
                  <td v-show="item.type_id === parseInt(chapterData.question_type)">
                    <input type="checkbox" v-bind:value="item.id" v-model="selectedQuesiton" class="question-seleted">
                  </td>
                  <td v-show="item.type_id === parseInt(chapterData.question_type)">{{ item.id }}</td>
                  <td v-show="item.type_id === parseInt(chapterData.question_type)">{{ item.type_id }}</td>
                  <td v-show="item.type_id === parseInt(chapterData.question_type)">{{ item.title }}</td>
                  <td v-show="item.type_id === parseInt(chapterData.question_type)"><input v-model="questionScore[item.id]" type="number" class="input number-input"></input></td>
                </tr>
              </tbody>
            </table>

            <pagination v-bind:pagination-data="paginationData"
                        v-model="data"
            ></pagination>
          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addChapter()" class="button is-success">确认</button>
        <button @click="switchModal()" class="button">取消</button>
      </footer>
    </div>

  </div>
</template>

<script>
import Pagination from './../Pagination'
export default {
  data() {
    return {
      isShowModal: false,
      chapterData: {
        name: null,
        score: null,
        number: null,
        describe: null,
        question_type: 0,
        scores: {},
      },
      questions: '',  // 涉及的题目
      questionsString: '',
      //
      paginationData: null,
      data: null,
      //
      questionData: {},
      selectedQuesiton: [],
      questionScore: [],
      scoreJson: {},
    }
  },
  components: {
    Pagination,
  },
  props: [
    'examinationPaperId',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.chapterData.name = '';
      that.chapterData.score = '';
      that.chapterData.number = '';
      that.chapterData.describe = '';
      that.chapterData.question_type = 0;
      that.selectedQuesiton = [];
      that.questionScore = [];
    },
    checkParameterIntegrity: function (data) {
      const that = this;
      let isIntegrity = true;
      let value;
      for (let i in data) {
        value = data[i];

        if (!value)  {
          isIntegrity = false;
          return isIntegrity;
        }
      }
      return isIntegrity

    },
    addChapter: function () {
      const that = this;
      let id = that.examinationPaperId;
      let questionsParams = this.GLOBAL.computedParams(that.selectedQuesiton, 'questions');
      let scores = that.computedAnswerJson();
      let isIntegrity = that.checkParameterIntegrity(scores)
      if (!isIntegrity) {
        alert('请将分值填写完整');
        return;
      }

      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${id}/sections?${questionsParams}`,
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          name: that.chapterData.name,
          score: that.chapterData.score,
          number: that.chapterData.number,
          describe: that.chapterData.describe,
          question_type: that.chapterData.question_type,
          scores: scores,
        }
      }).then(res => {
        alert('添加成功');
        that.clearWords();
        that.$emit('getChapter');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        console.log(err);
      })
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
    getQuestion: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/questions`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        param: {
          type: 'EXAM'
        }
      }).then(res => {
        that.questionData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {
  },
  watch: {
    selectedQuesiton: function (value, oldValue) {
      const that = this;
    },
    data:function (value, oldValue) {
      const that = this;
      that.questionData = value.data;
      that.paginationData = value.links;
    },
    isShowModal: function (value, oldVale) {
      const that = this;
      if (value) {
        this.getQuestion();
      }
    },
  }
}
</script>

<style scoped>
.question-seleted {
  width: 20px;
}
.modal-card {
  width: 1100px;
}
.number-input {
  width: 100px;
}
</style>
