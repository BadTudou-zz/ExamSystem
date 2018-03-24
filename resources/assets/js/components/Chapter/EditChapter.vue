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
          <label>问题类型</label>
          <input v-model="currentChapterData.chapter_type" class="input" type="text">
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
        name: null,
        score: null,
        number: null,
        describe: null,
        chapter_type: null
      },
      token: null,
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
      that.currentChapterData.chapter_type = '';
    },
    editChapter: function () {
      const that = this;
      let examinationPaperId = that.examinationPaperId;
      let chapterId = that.editData.id;
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/papers/${examinationPaperId}/sections/${chapterId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        },
        body: {
          name: that.currentChapterData.name,
          score: that.currentChapterData.score,
          number: that.currentChapterData.number,
          describe: that.currentChapterData.describe,
          chapter_type: that.currentChapterData.chapter_type
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
    }
  },
  creatad() {
    this.token = sessionStorage.getItem('token');
  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      that.currentChapterData.name = value.name;
      that.currentChapterData.score = value.score;
      that.currentChapterData.number = value.number;
      that.currentChapterData.describe = value.describe;
      that.currentChapterData.chapter_type = value.chapter_type;
    }
  }
}
</script>

<style>
</style>
