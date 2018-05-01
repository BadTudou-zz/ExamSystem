<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑视频</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">
        <div class="box-item">
          <label>视频名称</label>
          <input v-model="videoData.name" class="input" type="text" placeholder="请输入视频名">
        </div>
        <div class="box-item">
          <label>显示名称</label>
          <input v-model="videoData.display_name" class="input" type="text" placeholder="请输入视频名">
        </div>
        <div class="box-item">
          <label>显示描述</label>
          <input v-model="videoData.descripe" class="input" type="text" placeholder="请输入视频名">
        </div>
        <div class="box-item">
          <label>数量</label>
          <input v-model="videoData.number" class="input" type="text">
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="editVideo()" class="button is-success">确认</button>
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
        name: '',
        display_name: '',
        descripe: '',
        number: '',
      },
    }
  },
  components: {
  },
  props: [
    'editData',
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
    editVideo: function (index) {
      const that = this;
      let id = that.editData.id;
      axios({
        method: 'put',
        url: `${this.GLOBAL.localDomain}/api/v1/courses/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          name: that.videoData.name,
          display_name: that.videoData.display_name,
          descripe: that.videoData.descripe,  // ?? 拼写错误
          number: that.videoData.number
        }
      }).then(res => {
        alert('编辑成功');
        that.$emit('getVideo');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.clearWords();
        that.switchModal();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
        that.clearWords();
      })
    }
  },
  created() {

  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      // that.videoData = value;
      that.videoData.name = value.name;
      that.videoData.display_name = value.display_name;
      that.videoData.descripe = value.descripe;
      that.videoData.number = value.number;
    }
  }
}
</script>

<style>
</style>
