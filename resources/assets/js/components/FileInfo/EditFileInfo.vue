<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">编辑文件</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>

      <section class="modal-card-body">
        <div class="file-item-box">
          <label>文件名称</label>
          <input v-model="fileData.doc_name" class="input" type="text">
        </div>
        <div class="file-item-box">
          <label>知识点</label>
          <input v-model="fileData.kp" class="input" type="text">
        </div>
      </section>

      <footer class="modal-card-foot">
        <button @click="editFileInfo()" class="button is-success">确认</button>
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
      fileData: {
        id: '',
        doc_name: '',
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
      that.fileData.id = '';
      that.fileData.doc_name = '';
      that.fileData.kp = '';
    },
    editFileInfo: function () {
      const that = this;

      axios({
        method: 'POST',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/update/document`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          id: that.fileData.id, // 文件id
          docName: that.fileData.doc_name,  // 修改后的文件名称
          kp:  that.fileData.kp, // 修改后的知识点
        },
      }).then(res => {
        alert('编辑成功');
        that.$emit('getFileForCid');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
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
      that.fileData.id = value.id;
      that.fileData.doc_name = value.doc_name;
      that.fileData.kp = value.kp;
    }
  }
}
</script>

<style scoped>
.progress {
  margin: 15px 0 20px 0;
}
.file-item-box {
  margin: 25px 0
}
.file-item-box input {
  display: inline-block;
  width: 300px;
}
</style>
