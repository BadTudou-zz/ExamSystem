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
          <input v-model="chapterData.score" class="input" type="text">
        </div>
        <div class="box-item">
          <label>章节数</label>
          <input v-model="chapterData.number" class="input" type="text">
        </div>
        <div class="box-item">
          <label>章节描述</label>
          <input v-model="chapterData.describe" class="input" type="text">
        </div>
        <div class="box-item">
          <label>问题类型</label>
          <input v-model="chapterData.question_type" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-success">确认</button>
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
      chapterData: {
        name: null,
        score: null,
        number: null,
        describe: null,
        question_type: null
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
    addChapter: function () {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/1/sections/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          name: that.chapterData.name,
          score: that.chapterData.score,
          number: that.chapterData.number,
          describe: that.chapterData.describe,
          question_type: that.chapterData.question_type
        }
      }).then(res => {
      }).catch(err => {
        console.log(err)
      })
    },
  },
  created() {
    this.token = sessionStorage.getItem('token');
  }
}
</script>

<style>
</style>
