<!-- 查看视频 -->
<template lang="html">
  <div class="box">
    <div>
        <div v-show="isShowSearchVideo" class="search-box">
          <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入视频">
          <!-- <button class="button" type="button" name="button">查找视频</button> -->
          <div @click="searchVideo()" class="search-button"><i class="fas fa-search"></i></div>
        </div>
        <button v-show="isShowCreateVideo" @click="addVideo()" class="button add-video-button" type="button" name="button">添加视频</button>
    </div>
    <p v-if="!videoData" class="empty-message-prompt">暂无视频</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <th>ID</th>
          <th>视频名</th>
          <th>视频别名</th>
          <th>视频数</th>
          <th>视频描述</th>
          <th>创建时间</th>
          <!-- <th>更新时间</th> -->
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in videoData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.number }}</td>
          <td><p class="limit-words">{{ item.descripe }}</p></td>
          <td>{{ GLOBAL.toTime(item.created_at) }}</td>
          <!-- <td>{{ GLOBAL.toTime(item.updated_at) }}</td> -->
          <td>
            <div v-show="isShowDeleteVideo" @click="deleteVideo(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
            <!-- <button v-show="isShowDeleteVideo" @click="deleteVideo(index)" class="delete" type="button" name="button">删除视频</button> -->
            <div v-show="isShowEditVideo" @click="editVideo(index)" class="icon-button"><i class="fas fa-edit"></i></div>
          </td>
        </tr>
      </tbody>
    </table>

    <add-video ref="addVideo"
                v-on:getVideo="getVideo"
    ></add-video>

    <edit-video ref="editVideo"
                 v-on:getVideo="getVideo"
                 v-bind:edit-data="editData"
    ></edit-video>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>
  </div>
</template>

<script>
import AddVideo from './AddVideo'
import EditVideo from './EditVideo'
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      isShowModal: false,
      videoData: null,
      editData: null,
      paginationData: null,
      data: null,
      searchKey: '',
      // get all video
      currentVideo: [],
      allVideo: [],
      searchResult: [],

    }
  },
  components: {
    AddVideo,
    EditVideo,
    Pagination,
  },
  methods: {
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
          url: `${this.GLOBAL.localDomain}/api/v1/courses/${id}`,
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
        url: `${this.GLOBAL.localDomain}/api/v1/courses`,
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
        let url = `${this.GLOBAL.localDomain}/api/v1/courses/`;
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
    data:function (value, oldValue) {
      const that = this;
      that.videoData = value.data;
      that.paginationData = value.links;
    },
    allVideo: function (value, oldValue) {
      const that = this;
      that.searchVideo(that.searchKey);
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
</style>
