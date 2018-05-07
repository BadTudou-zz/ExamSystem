<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">添加视频</p>
        <button @click="switchModal()" class="delete" aria-label="close"></button>
      </header>

      <section class="modal-card-body">

        <div>
          <div class="file has-name is-fullwidth">
            <label class="file-label">
              <input v-on:change="fire($event)" class="file-input" type="file" name="pic">
              <span class="file-cta">
                <span class="file-icon">
                  <i class="fas fa-upload"></i>
                </span>
                <span class="file-label">选择视频</span>
              </span>
              <span class="file-name">{{ filename }}</span>
            </label>
          </div>
          <progress v-show="progressNumber" class="progress is-info" v-bind:value="progressWidth" max="100">{{ progressNumber }}</progress>
        </div>

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
        <button @click="addVideoInfo()" class="button is-success">确认添加</button>
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
      that.videoData.videoName = '';
      that.videoData.kp = '';
      that.isUploadedSuccess = false;
      // that.progressNumber = '';
      // that.progressWidth = '';

      that.clock = null;
      that.postfix = null;
      that.time = null;
      that.filename = null;
      that.userid = null;
      that.cid = null;
      that.end = null;
      that.sta = 0;
      that.progressNumber = '';
      that.progressWidth = '';
      that.isUploadedSuccess = false;  // 记录是否上传成功
    },
    addVideoInfo: function () {
      const that = this;
      if (!that.isUploadedSuccess) {
        alert('请先上传视频');
        return;
      }
      that.userId = sessionStorage.getItem('userId')
      let teachingId = that.currentTeachingData.id;

      that.cid = teachingId;  // 授课ID

      axios({
        method: 'POST',
        url: `https://www.badtudou.com/api/v1/upload/lecture/insert/video`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          userid: that.userId,
          cid: that.cid,  // 授课Id
          filename: this.filename,  // 文件名称（js生成唯一表示名称）
          videoName: that.videoData.videoName,  // 视频名称（由用户输入）
          kp: that.videoData.kp,  // 知识点（由用户输入）
        },
      }).then(res => {
        alert('添加成功')
        that.clearWords();
        that.$emit('getTeaching');   //第一个参数名为调用的方法名，第二个参数为需要传递的参数
        that.switchModal();
      }).catch(err => {
        alert('添加失败');
        that.clearWords();
        return;
        console.log(err);
      })
    },
    // 分段上传
    up(fd){
      axios({
        method: 'POST',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/video`,
        data: fd,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          filename: this.filename,
        },
      }).then(res => {
        // alert('up成功！')
      }).catch(err => {
        // alert('上传失败');
        return;
        console.log(err);
      })
    },
    fire: function (file){
      const that = this;
      var name = file.target.value;
      var pos = name.lastIndexOf('.');
      var myDate = new Date();
      var postfix = name.substring(pos+1);
      var time = myDate.getFullYear() + '-' + (myDate.getMonth() + 1) + '-'+ myDate.getDate() + '-' + Math.ceil(Math.random() * 100000);
      this.filename = time + '.' + postfix;
      // this.clock =  setInterval(this.sendfile(),1000);

      this.clock =  setInterval(() => {
                        that.sendfile();
                    }, 1000)
    },
    sendfile: function() {
      const that = this;
      (function (){
          const  LENGTH = 5 * 1024 * 1024; //每一次上传10M
          // 开始截取位置

          // 截取结束的位置。
          that.end = that.sta + LENGTH;
          //标识上一块是否上传完毕。
          var flag = false;
          // 设置一个blob变量
          var blob = null;
          // 设置一个HTML5的文件对象。
          var fd = null;
          // 设置百分比
          var percent = 0;
          (function (){
              if(flag === true){
                  return;
              }
              // 获取文件信息
              var mov = document.getElementsByName('pic')[0].files[0];
              // 如果sta>mov.size
              if(that.sta > mov.size){
                  clearInterval(that.clock);
                  // that.info(that.userid, that.cid);
                  that.isUploadedSuccess = true;
                  alert("上传成功");
                  return ;
              }

              blob = mov.slice(that.sta, that.end);

              fd = new FormData();

              fd.append('part',blob);

              that.up(fd);

              that.sta = that.end;

              that.end = that.sta + LENGTH;

              flag = false;

              percent = 100 * that.end / mov.size;

              if (percent>100) {
                  percent=100;
              }
              that.progressWidth = percent;
              that.progressNumber = parseInt(percent) + '%';``
          })(that.sta, that.end);

      })(that.userid, that.cid);
    },
  },
  created() {
  },
  watch: {
    isShowModal: function (value, oldValue) {
      const that = this;
      if (value) {
          //
      }
      else {
        that.clearWords();
      }
    }
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
