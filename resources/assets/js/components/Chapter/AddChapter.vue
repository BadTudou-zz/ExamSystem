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
          <label>章节数</label>
          <input v-model="chapterData.number" class="input" type="number">
        </div>
        <div class="box-item">
          <label>章节描述</label>
          <input v-model="chapterData.describe" class="input" type="text">
        </div>
        <div class="box-item">
          <label>问题类型</label>
          <div class="select">
            <select v-model="chapterData.question_type">
              <option value="SINGLE_CHOICE">单选</option>
              <option value="MULTIPLE_CHOICE">多选</option>
              <option value="TRUE_FALSE">判断</option>
              <option value="FILL_IN">填空</option>
              <option value="SHORT_ANSWER">简答</option>
            </select>
          </div>
        </div>
        <div class="box-item">
          <label>涉及到的问题</label>
          <!-- <inpust v-model="questionsString" class="input" type="text" placeholder="请用英文逗号将多个问题id分开"> -->
          <div class="all-question">

            <table class="table">
              <thead>
                <tr>
                  <th>是否选中</th>
                  <th>序号</th>
                  <th>题目</th>
                  <th>类型</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item,index) in questionData">
                  <td v-show="item.question_type === chapterData.question_type"><input type="checkbox" v-bind:value="item.id" v-model="selectedQuesiton" class="question-seleted"></td>
                  <td v-show="item.question_type === chapterData.question_type">{{ item.id }}</td>
                  <td v-show="item.question_type === chapterData.question_type">{{ item.title }}</td>
                  <td v-show="item.question_type === chapterData.question_type">{{ item.question_type }}</td>
                </tr>
              </tbody>
            </table>

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
export default {
  data() {
    return {
      isShowModal: false,
      chapterData: {
        name: null,
        score: null,
        number: null,
        describe: null,
        question_type: 'SINGLE_CHOICE',
      },
      questions: '',  // 涉及的问题
      questionsString: '',

      questionData: {},
      selectedQuesiton: [],
    }
  },
  components: {
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
      that.chapterData.question_type = '';
    },
    addChapter: function () {
      const that = this;
      let id = that.examinationPaperId;
      let questionsParams = that.computedParams(that.selectedQuesiton, 'questions');
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${id}/sections/?${questionsParams}`,
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
          question_type: that.chapterData.question_type
        }
      }).then(res => {
        alert('添加成功');
        that.clearWords();
        that.$emit('getChapter');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        console.log(err);
        that.clearWords();
      })
    },
    /**
     * computedParams
     * @param  {Array} selectedQuesiton   选中的问题数组
     * @param  {String} param param拼接参数
     * @return {String}       拼接完成的params
     */
    computedParams: function (selectedQuesiton, param) {
      let arr = selectedQuesiton;
      let string = '';
      for (let i = 0; i < arr.length; i++) {
        if (i != 0) {
          string += '&' + param + '[' + i + ']' + '=' + arr[i];
        }
        else {
          string += param + '[' + i + ']' + '=' + arr[i];
        }
      }
      return string;
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
  },
  created() {
    this.getQuestion();
  },
  watch: {
    selectedQuesiton: function (value, oldValue) {
      const that = this;
      console.log(value)
    }
  }
}
</script>

<style scoped>
.question-seleted {
  width: 20px;
}
</style>
