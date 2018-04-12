<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑试卷</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>章节名称</label>
          <input v-model="currentExaminationPaperData.name" class="input" type="text" placeholder="请输入章节名">
        </div>
        <div class="box-item">
          <label>章节成绩</label>
          <input v-model="currentExaminationPaperData.score" class="input" type="text">
        </div>
        <div class="box-item">
          <label>章节数</label>
          <input v-model="currentExaminationPaperData.number" class="input" type="text">
        </div>
        <div class="box-item">
          <label>章节描述</label>
          <input v-model="currentExaminationPaperData.describe" class="input" type="text">
        </div>
        <div class="box-item">
          <label>问题类型</label>
          <input v-model="currentExaminationPaperData.question_type" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="editExaminationPaper()" class="button is-success">确认</button>
        <button @click="switchModal()" class="button">取消</button>
      </footer>
    </div>

  </div>
</template>

<script>
export default {
  data() {
    return {
      currentExaminationPaperData: {
        title: null,
        score: null,
        min: null,
        describe: null
      },
      isShowModal: false,
    }
  },
  props: [
    'editData',
  ],
  components: {

  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.currentExaminationPaperData.title = '';
      that.currentExaminationPaperData.score = '';
      that.currentExaminationPaperData.min = '';
      that.currentExaminationPaperData.describe = '';
    },
    editExaminationPaper: function () {
      const that = this;
      let id = that.editData['id'];
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          title: that.currentExaminationPaperData.title,
          score: that.currentExaminationPaperData.score,
          min: that.currentExaminationPaperData.min,
          describe: that.currentExaminationPaperData.describe
        }
      }).then(res => {
        alert('编辑成功');
        that.$emit('getExaminationPaper');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  creatad() {

  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.currentExaminationPaperData.id = value.id;
      that.currentExaminationPaperData.name = value.name;
      that.currentExaminationPaperData.describe = value.describe;
      that.currentExaminationPaperData.max = value.max;
    }
  }
}
</script>

<style>
</style>
