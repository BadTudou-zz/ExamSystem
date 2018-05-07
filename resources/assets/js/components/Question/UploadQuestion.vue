<template>
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">从Excel导入问题</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>
      <section class="modal-card-body">

        <div class="file has-name is-boxed">
          <label class="file-label">
            <input v-on:change="getFileInfo($event)" id="file" class="file-input" type="file" name="resume">
            <span class="file-cta">
              <span class="file-icon">
                <i class="fas fa-upload"></i>
              </span>
              <span class="file-label">
                Choose a file…
              </span>
            </span>
            <span class="file-name">{{ fileName }}</span>
          </label>
        </div>
      </section>
      <footer class="modal-card-foot">
        <button @click="upload()" class="button is-success">确认导入</button>
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
      fileData: null,
      fileName: '',
    }
  },
  components: {
  },
  // props: {
  //   'showUpload',
  // },
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
      that.clearWords();
    },
    clearWords: function () {
      const that = this;
      that.fileData = null;
      that.fileName = '';
    },
    getFileInfo: function (event) {
      const that = this;
      that.fileName = event.target.value;
      that.fileData = event.target.files[0];
    },
    upload: function (event) {
      const that = this;

      //准备FormData对象
      let formData = new FormData();

      //将文件放入FormData对象中
      formData.append('document', that.fileData);  // files[0] 代表选择的是一个文件。请不要设置 input file里面的multiple 多文件上传
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/import`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        data: formData,
      }).then(res => {
        alert('导入成功');
        that.clearWords();
        that.$emit('getRole');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('导入失败');
      })
    }
  },
  created() {
  },
  watch: {
    // showUpload: function (value, oldValue) {
    //   const that = this;
    //   that.showUpload = value;
    // }
  }
}
</script>

<style scoped>
.file-label {
  width: 256px;
  text-align: center;
}
.select {
  margin: 0 9px 20px 9px;
}
</style>
