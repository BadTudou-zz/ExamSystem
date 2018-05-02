<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加预习</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>

      <section class="modal-card-body">

        <div class="preview-item-box">
          <label>名称</label>
          <input v-model="previewData.previewName" class="input" type="text">
        </div>

        <div class="preview-item-box">
          <label>描述</label>
          <input v-model="previewData.desc" class="input" type="text">
        </div>

        <div class="preview-item-box">
          <label>内容</label>
          <input v-model="previewData.content" class="input" type="text">
        </div>

        <div class="preview-item-box">
          <label>预习结束时间</label>
          <input v-model="previewData.endTime" class="input" type="date">
        </div>

      </section>
      <footer class="modal-card-foot">
        <button @click="addPreview()" class="button is-success">确认</button>
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
      previewData: {
        previewName: '',
        cid: '',
        userid: '',
        desc: '',
        content: '',
        endTime: ''
      },
      clock: null,
      postfix: null,
      time: null,
      filename: null,
      userid: null,
      cid: null,
      end: null,
      sta: 0,
      progressNumber: '',
      progressWidth: '',
      isUploadedSuccess: false,  // 记录是否上传成功
    }
  },
  components: {
  },
  props: [
    'currentTeachingData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.previewData.previewName = '';
      that.previewData.cid = '';
      that.previewData.userid = '';
      that.previewData.desc = '';
      that.previewData.content = '';
      that.previewData.endTime = '';
    },
    addPreview: function () {
      const that = this;

      that.userId = sessionStorage.getItem('userId')
      let teachingId = that.currentTeachingData.id;
      that.cid = teachingId;  // 授课ID
      let a = that.previewData.endTime;
      let time = this.GLOBAL.toServerTime(that.previewData.endTime);
      debugger

      axios({
        method: 'POST',
        // url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/insert/preview`,
        url: `${this.GLOBAL.localDomain}/api/v1/preview/insert`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          previewName: that.previewData.previewName,
          cid: that.previewData.cid,  // 授课Id
          userid: this.previewData.userid,  // 文件名称（js生成唯一表示名称）
          desc: that.previewData.desc,  // 预习名称（由用户输入）
          content: that.previewData.content,  // 知识点（由用户输入）
          endTime: this.GLOBAL.toServerTime(that.previewData.endTime),
        },
      }).then(res => {
        alert('添加成功');
        that.clearWords();
        that.$emit('getPreview');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        return;
        console.log(err);
      })
    },
  },
  created() {
  },
  watch: {
    currentTeachingData: function (value, oldValue) {
      const that = this;
      that.previewData.cid = value.id;
      that.previewData.userid = sessionStorage.getItem('userId');
    }
  }
}
</script>

<style scoped>
.progress {
  margin: 15px 0 20px 0;
}
.preview-item-box {
  margin: 25px 0
}
.preview-item-box input {
  display: inline-block;
  width: 300px;
}
</style>
