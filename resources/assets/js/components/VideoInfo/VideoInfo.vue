<!-- 查看视频 -->
<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content">
      <div class="box">

        <div v-show="isShowSearchVideo" class="search-box">
          <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入视频">
          <div class="search-button"><i class="fas fa-search"></i></div>
        </div>
        <button v-show="isShowCreateVideo"  class="button add-video-button" type="button" name="button">添加视频</button>

      </div>
    </div>
    <button class="modal-close is-large" aria-label="close"></button>
  </div>

  <!-- <add-video></add-video> -->

  <!-- <edit-video ref="editVideo"
               v-on:getVideo="getVideo"
               v-bind:edit-data="editData"
  ></edit-video> -->

  <!-- <pagination v-show="searchResult.length === 0"
              v-bind:pagination-data="paginationData"
              v-model="data"
  ></pagination> -->
</template>

<script>
// import AddVideo from './AddVideo'
// import EditVideo from './EditVideo'
// import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      isShowModal: false,
      videoData: null,
      paginationData: null,
      data: null,
      searchKey: '',
      // get all video
      currentVideo: [],
      allVideo: [],
      searchResult: [],

      clock: null,
      postfix: null,
      time: null,
      filename: null,
      userid: '1',
      cid: '1',
      end: null,
      sta: 0,
    }
  },
  components: {
    // AddVideo,
    // EditVideo,
    // Pagination,
  },
  props: [
    'editData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    // 分段上传
    up(fd){
      axios({
        method: 'POST',
        // url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/video?filename='+filename,`,
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
        alert('上传失败');
        return;
        console.log(err);
      })
    },
    info(userid,cid){
      axios({
        method: 'POST',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/insert`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          userid: userid,
          cid: cid,
          filename: this.filename,
        }
      }).then(res => {
        // alert('info成功')
      }).catch(err => {
        // alert('info失败');
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
                  that.info(that.userid, that.cid);
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
              document.getElementById('bar').style.width = percent + '%';
              document.getElementById('bar').innerHTML = parseInt(percent) + '%';
          })(that.sta, that.end);

      })(that.userid, that.cid);
    },
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addVideo: function() {
      const that = this;
      that.$refs.addVideo.switchModal();
    },
    editVideo: function (index) {
      const that = this;
      that.editData = that.videoData[index];
      that.$refs.editVideo.switchModal();
    },
    deleteVideo: function (index) {
      const that = this;
      let id = that.videoData[index]['id'];
      let prompt = confirm("确认删除该视频吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/videos/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功');
          that.getVideo()
        }).catch(err => {
          alert('删除失败')
          console.log(err)
        })
      }
    },
    getVideo: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/videos`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.videoData = res.data.data;
        that.paginationData = res.data.links;
        //
      }).catch(err => {
        console.log(err);
        if (err.response.status === 401) {
          // alert('登录超时');
          // location.reload();
        }
      })
    },
    searchVideo: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getVideo();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allVideo.length > 0) {
        let allData  = that.allVideo;
        let len = that.allVideo.length;
        let res = [];

        for (let i = 0; i < len; i++) {
          for (let j in allData[i]) {
            if (allData[i][j]) {
              if ((allData[i][j].toString()).indexOf(that.searchKey) !== -1) {
                res.push(allData[i]);
                break;
              }
            }
          }
        }
        that.searchResult = res;
        that.videoData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/videos/`;
        that.getAllVideo(url);
      }
    },
    getAllVideo: function (url) {
      const that = this;
      let urlPath = url ? url : that.url
      axios({
        method: 'get',
        url: urlPath,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.url = res.data.links.next;

        let len = res.data.data.length ? res.data.data.length : that.getJsonLength(res.data.data);

        // data数据结构不一致 可能是数组/也可能是json
        if (res.data.data.length) {
          for (let i = 0; i < len; i++) {
            that.currentVideo.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentVideo.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllVideo(that.url);
        }
        else {
          that.allVideo = that.currentVideo;
        }
      }).catch(err => {
        console.log(err);
      })
    },

  },
  computed: {
    isShowCreateVideo() {
      return true;
      // return sessionStorage.getItem('permissions').includes('video-store');
    },
    isShowSearchVideo() {
      return true;
      // return sessionStorage.getItem('permissions').includes('video-show');
    },
    isShowEditVideo() {
      return true;
      // return sessionStorage.getItem('permissions').includes('video-update');
    },
    isShowDeleteVideo() {
      return true;
      // return sessionStorage.getItem('permissions').includes('video-destroy');
    },
  },
  created() {
    this.getVideo();
  },
  watch: {
    // data:function (value, oldValue) {
    //   const that = this;
    //   that.videoData = value.data;
    //   that.paginationData = value.links;
    // },
    editData: function (value, oldValue) {
      const that = this;
    }
  }
}
</script>

<style lang="scss">
table {
  margin: 35px auto 0 auto;
}
.search-input {
  width: 200px;
  display: inline-block;
  margin-right: 10px;
}
.search-box {
  padding-right: 20px;
  display: inline-block;
  border-right: 1px solid #dedede;
}
.add-video-button {
  margin-left: 20px;
}
.box-item {
  margin-bottom: 20px;
  input  {
    display: inline-block;
    width: 300px;
  }
  label {
    display: inline-block;
    width: 130px;
  }
}
.modal-content {
  width: 1200px;
}
</style>
