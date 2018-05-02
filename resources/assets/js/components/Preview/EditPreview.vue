<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑预习</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>

      <section class="modal-card-body">
<!-- 
        that.previewData.previewName = value.previewName, // 修改后的预习名称
        that.previewData.cid = value.cid,  // 修改后的授课id（可以重新选择该预习放到其他授课下面）
        that.previewData.desc = value.desc,  // 修改后的预习描述
        that.previewData.content = value.content,  // 修改后的预习内容
        that.previewData.endTime = value.endTime,  // 修改后的预习结束时间
        that.previewData.isPublish = value.isPublish,  // 修改是否发布 （1代表已经发布，0代表不发布）
        that.previewData.id = value.id  // 要更新的预习id -->

        <div class="preview-item-box">
          <label>预习名称</label>
          <input v-model="previewData.preview_name" class="input" type="text">
        </div>

        <div class="preview-item-box">
          <label>授课id</label>
          <input v-model="previewData.preview_name" class="input" type="text">
        </div>


        <div class="preview-item-box">
          <label>描述</label>
          <input v-model="previewData.preview_name" class="input" type="text">
        </div>

        <div class="preview-item-box">
          <label>内容</label>
          <input v-model="previewData.kp" class="input" type="text">
        </div>

        <div class="preview-item-box">
          <label>结束时间</label>
          <input v-model="previewData.kp" class="input" type="text">
        </div>

        <div class="preview-item-box">
          <label>修改是否发布</label>
          <input v-model="previewData.kp" class="input" type="text">
        </div>
      </section>

      <footer class="modal-card-foot">
        <button @click="editPreview()" class="button is-success">确认</button>
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
        id: '',
        preview_name: '',
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
      that.previewData.previewName = '';
      that.previewData.cid = '';
      that.previewData.desc = '';
      that.previewData.content = '';
      that.previewData.endTime = '';
      that.previewData.isPublish = '';
      that.previewData.id = '';
    },
    editPreview: function () {
      const that = this;

      axios({
        method: 'POST',
        url: `${this.GLOBAL.localDomain}/api/v1/preview/update`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          // id: that.previewData.id, // 预习id
          // previewName: that.previewData.preview_name,  // 修改后的预习名称
          // kp:  that.previewData.kp, // 修改后的知识点

          previewName: that.previewName, // 修改后的预习名称
          cid: that.cid,  // 修改后的授课id（可以重新选择该预习放到其他授课下面）
          desc: that.desc,  // 修改后的预习描述
          content: that.content,  // 修改后的预习内容
          endTime: that.endTime,  // 修改后的预习结束时间
          isPublish: that.isPublish,  // 修改是否发布 （1代表已经发布，0代表不发布）
          id: that.id  // 要更新的预习id

        },
      }).then(res => {
        alert('编辑成功');
        that.$emit('getPreviewForCid');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
        that.clearWords();
      }).catch(err => {
        alert('编辑失败');
        console.log(err);
      })
    },
  },
  created() {
  },
  watch: {
    editData: function (value, oldValue) {
      const that = this;
      // that.previewData.id = value.id;
      // that.previewData.preview_name = value.preview_name;
      // that.previewData.kp = value.kp;
      that.previewData.previewName = value.previewName, // 修改后的预习名称
      that.previewData.cid = value.cid,  // 修改后的授课id（可以重新选择该预习放到其他授课下面）
      that.previewData.desc = value.desc,  // 修改后的预习描述
      that.previewData.content = value.content,  // 修改后的预习内容
      that.previewData.endTime = value.endTime,  // 修改后的预习结束时间
      that.previewData.isPublish = value.isPublish,  // 修改是否发布 （1代表已经发布，0代表不发布）
      that.previewData.id = value.id  // 要更新的预习id
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
