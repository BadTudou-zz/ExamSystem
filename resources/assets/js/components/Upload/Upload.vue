<template>
  <div class="box">
    <div class="file has-name is-boxed">
      <label class="file-label">
        <input v-on:change="upload($event)" id="file" class="file-input" type="file" name="resume">
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
    <!-- <button @click="upload()" class="button is-small is-primary" type="button" name="button">确认上传</button> -->
  </div>
</template>

<script>

export default {
  data() {
    return {
      fileData: null,
      fileName: '',
    };
  },
  components: {
  },
  methods: {
    upload: function (event) {
      const that = this;
      console.log('上传');

      //准备FormData对象
      let formData = new FormData();

      that.fileName = event.target.value;
      that.fileData = event.target.files[0];

      // let uploadFile = document.getElementById('file');

      let data = that.fileData;

      //将文件放入FormData对象中
      // formData.append('document', uploadFile.files[0]);  // files[0] 代表选择的是一个文件。请不要设置 input file里面的multiple 多文件上传
      formData.append('document', that.fileData);  // files[0] 代表选择的是一个文件。请不要设置 input file里面的multiple 多文件上传

      // 开始上传
      // axios({
      //     url:'xxx/questions/import/student',
      //     method:'post',
      //     data:formData,
      //     headers{这里该加的验证都要加}
      // }).then((res)=>{console.log(res)})

      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/questions/import/student`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        data: formData,
      }).then(res => {
        alert('上传成功');
        // that.clearWords();
        // that.$emit('getTest');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        // that.switchModal();
      }).catch(err => {

      })
    }
  },
  created() {
  },
  watch: {
  }
}
</script>

<style scoped>
.file-label {
  width: 256px;
  text-align: center;
}
</style>
