<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加考试</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>考试题目</label>
          <input v-model="testData.title" class="input" type="text" placeholder="请输入英文名">
        </div>
        <div class="box-item">
          <label>数目</label>
          <input v-model="testData.number" class="input" type="text" placeholder="请输入中文名">
        </div>
        <div class="box-item">
          <label>类型</label>
          <input v-model="testData.exam_type" class="input" type="text" placeholder="请输入考试名">
        </div>
        <div class="box-item">
          <label>描述</label>
          <input v-model="testData.describe" class="input" type="text">
        </div>
        <div class="box-item">
          <label>成绩</label>
          <input v-model="testData.score" class="input" type="text">
        </div>
        <div class="box-item">
          <label>最小值</label>
          <input v-model="testData.min" class="input" type="text">
        </div>
        <div class="box-item">
          <label>开始时间</label>
          <input v-model="testData.begin_at" class="input" type="date">
        </div>
        <div class="box-item">
          <label>相关的试卷ID</label>
          <input v-model="testData.paper_id" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="addTest()" class="button is-success">确认</button>
        <button  @click="switchModal()" class="button">取消</button>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isShowModal: false,
      testData: {
        title: '',
        number: '',
        exam_type: '',
        describe: '',
        score: '',
        min: '',
        begin_at: '',
        paper_id: ''
      },
      token: null,
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
      that.testData.title =  '';
      that.testData.number =  '';
      that.testData.exam_type =  '';
      that.testData.describe =  '';
      that.testData.score =  '';
      that.testData.min =  '';
      that.testData.begin_at =  '';
      that.testData.paper_id =  '';
    },
    addTest: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/exams/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token,
        },
        params: {
          title: that.testData.title,
          number: that.testData.number,
          exam_type: that.testData.exam_type,
          describe: that.testData.describe,
          score: that.testData.score,
          min: that.testData.min,
          begin_at: that.testData.begin_at,
          paper_id: that.testData.paper_id,
        }
      }).then(res => {
        alert('添加成功');
        that.$emit('getTest');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {
    this.token = sessionStorage.getItem('token');
  }
}
</script>

<style>
</style>
