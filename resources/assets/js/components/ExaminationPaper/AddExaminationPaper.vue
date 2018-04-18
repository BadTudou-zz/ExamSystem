<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加试卷</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>试卷标题</label>
          <input v-model="examinationPaperData.title" class="input" type="text">
        </div>
        <div class="box-item">
          <label>总分</label>
          <input v-model="examinationPaperData.score" class="input" type="number">
        </div>
        <div class="box-item">
          <label>时长(分钟)</label>
          <input v-model="examinationPaperData.min" class="input" type="number">
        </div>
        <div class="box-item">
          <label>描述</label>
          <input v-model="examinationPaperData.describe" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addExaminationPaper()" class="button is-success">确认</button>
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
      examinationPaperData: {
        title: null,
        score: null,
        min: null,
        describe: null
      },
    }
  },
  components: {
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.examinationPaperData.name = '';
      that.examinationPaperData.describe = '';
      that.examinationPaperData.max = '';
    },
    addExaminationPaper: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          title: that.examinationPaperData.title,
          score: that.examinationPaperData.score,
          min: that.examinationPaperData.min,
          describe: that.examinationPaperData.describe
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getExaminationPaper');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {

  }
}
</script>
<style>
</style>
