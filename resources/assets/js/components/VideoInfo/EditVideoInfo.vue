<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加视频</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>

      <section class="modal-card-body">

        <div class="video-item-box">
          <label>视频名称</label>
          <input v-model="videoData.videoName" class="input" type="text">
        </div>
        <div class="video-item-box">
          <label>知识点</label>
          <input v-model="videoData.kp" class="input" type="text">
        </div>
      </section>

      <footer class="modal-card-foot">
        <button @click="editVideoInfo()" class="button is-success">确认</button>
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
      videoData: {
        videoName: '',
        kp: '',
      },
      cid: null,
    }
  },
  components: {
  },
  props: [
    'editData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    clearWords: function () {
      const that = this;
      that.videoData.name = '';
      that.videoData.display_name = '';
      that.videoData.descripe = '';
      that.videoData.number = '';
    },
    editVideoInfo: function () {
      const that = this;

      axios({
        method: 'POST',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/update/video`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        body: {
          id: that.editData.id, // 视频id
          videoName: that.videoData.videoName,  // 修改后的视频名称
          kp:  that.videoData.videoName, // 修改后的知识点
        },
      }).then(res => {
        alert('编辑成功')
      }).catch(err => {
        alert('编辑失败')
        console.log(err);
      })
    },
  },
  created() {
  },
  watch: {
  }
}
</script>

<style scoped>
.progress {
  margin: 15px 0 20px 0;
}
.video-item-box {
  margin: 25px 0
}
.video-item-box input {
  display: inline-block;
  width: 300px;
}
</style>
