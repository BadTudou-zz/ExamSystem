<!-- 查看视频 -->
<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content">
      <div class="box">

        <div class="search-box">
          <div class="field">
            <div class="control">
              <div class="select is-small">
                <select  v-model="searchType" @change="changeSeachType(index)">
                  <option value="">请查找类型</option>
                  <option value="fuzzy-search">模糊查找</option>
                  <option value="user-id-search">根据用户ID查找</option>
                  <option value="lecture-id-search">根据授课ID查找</option>
                </select>
              </div>
            </div>
          </div>

          <input v-model="searchKey" class="input search-input" type="text" placeholder="">
          <div class="search-button"><i class="fas fa-search"></i></div>
        </div>

        <button @click="addVideoInfo()" class="button add-video-button" type="button" name="button">添加视频</button>

        <p v-if="!videoData" class="empty-message-prompt">暂无视频</p>
        <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
          <thead>
            <tr>
              <th>序号</th>
              <th>视频名</th>
              <th>文件名</th>
              <th>知识点</th>
              <th>操作</th>
            </tr>
          </thead>
        <tbody>
            <tr v-for="(item,index) in videoData">
              <td>{{ item.id }}</td>
              <td>{{ item.videoName }}</td>
              <td>{{ item.filename }}</td>
              <td>{{ item.kp }}</td>
              <td>
                <div @click="deleteVideo(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
                <div @click="editVideoInfo(index)" class="icon-button"><i class="fas fa-edit"></i></div>
              </td>
            </tr>
          </tbody>
        </table>

        <pagination v-show="searchResult.length === 0"
                    v-bind:pagination-data="paginationData"
                    v-model="data"
        ></pagination>

      </div>
    </div>
    <button class="modal-close is-large" aria-label="close"></button>


    <add-video-info ref="addVideoInfo"
                    v-on:getVideo="getVideo"
                    v-bind:current-video-data="currentVideoData"></add-video-info>

    <edit-video-info ref="editVideoInfo"
                     v-on:getVideo="getVideo"
                     v-bind:edit-data="editData"
    ></edit-video-info>

  </div>

</template>

<script>
import AddVideoInfo from './AddVideoInfo'
import EditVideoInfo from './EditVideoInfo'
import Pagination from './../Pagination.vue'

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
      editData: null,
      searchType: '',
    }
  },
  components: {
    AddVideoInfo,
    EditVideoInfo,
    Pagination,
  },
  props: [
    'currentVideoData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addVideoInfo: function() {
      const that = this;
      that.$refs.addVideoInfo.switchModal();
    },
    editVideoInfo: function (index) {
      const that = this;
      that.editData = that.videoData[index];
      that.$refs.editVideoInfo.switchModal();
    },
    deleteVideo: function (index) {
      const that = this;
      let id = that.videoData[index]['id'];
      let prompt = confirm("确认删除该视频吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/delete/video`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          },
          params: {
            id: that.videoData[index]['id']
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
    // 通过授课ID获取视频信息
    getVideoForCid: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/selectForUserid/video`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          cid: that.cid,
        }
      }).then(res => {
        // that.videoData = res.data.data;
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
      })
    },
    // 通过user获取视频信息
    getVideoForUserId: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/selectForCid/video`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          userId: sessionStorage.getItem('userId')
        }
      }).then(res => {
        // that.videoData = res.data.data;
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
      })
    },
    getVideo: function() {
      const that = this;
      // axios({
      //   method: 'get',
      //   url: `${this.GLOBAL.localDomain}/api/v1/videos`,
      //   headers: {
      //     'Accept': 'application/json',
      //     'Authorization': sessionStorage.getItem('token'),
      //   }
      // }).then(res => {
      //   that.videoData = res.data.data;
      //   that.paginationData = res.data.links;
      //   //
      // }).catch(err => {
      //   console.log(err);
      //   if (err.response.status === 401) {
      //     // alert('登录超时');
      //     // location.reload();
      //   }
      // })
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
    changeSeachType: function () {
      const that = this;
      let searchType = that.searchType;
      switch (searchType) {
        case '':
          break;
        case 'fuzzy-search':
          that.getVideo();
          break;
        case 'user-id-search':
          that.getVideoForUserId();
          break;
        case 'lecture-id-search':
          that.getVideoForCid();
          break;
      }
    }
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
    isShowEditVideoInfo() {
      return true;
      // return sessionStorage.getItem('permissions').includes('video-update');
    },
    isShowDeleteVideo() {
      return true;
      // return sessionStorage.getItem('permissions').includes('video-destroy');
    },
  },
  created() {
  },
  watch: {
    isShowModal: function () {
      const that = this;
      that.getVideoForUserId();
    }
  }
}
</script>

// <style lang="scss" scoped>
table {
  margin: 35px auto 0 auto;
}
.search-input {
  width: 200px;
  display: inline-block;
  margin-right: 10px;
}
.search-box {
  width: 400px;
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
.field {
  display: inline-block;
}
</style>
