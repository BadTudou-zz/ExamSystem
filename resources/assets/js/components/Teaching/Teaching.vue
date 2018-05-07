<!-- 查看授课 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchTeaching" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
        <!-- <button disabled @click="searchTeaching()" class="button" type="button" name="button">查找授课</button> -->
        <div @click="searchTeaching()" class="search-button"><i class="fas fa-search"></i></div>
      </div>
        <button v-show="isShowCreateTeaching" @click="addTeaching()" class="button add-teaching-button" type="button" name="button">添加授课</button>
        <button class="button add-teaching-button" type="button" name="button">同步授课</button>
    </div>

    <p v-if="!teachingData" class="empty-message-prompt">暂无授课</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <th>授课名</th>
          <!-- <th>描述</th> -->
          <th>最大容量</th>
          <th>当前容量</th>
          <th>授课操作</th>
          <th>其他操作</th>
        </tr>
      </thead>
    <tbody>
        <tr v-for="(item,index) in teachingData">
          <td>{{ item.name }}</td>
          <!-- <td><p class="limit-words">{{ item.description }}</p></td> -->
          <td>{{ item.max }}</td>
          <td>{{ item.current }}</td>
          <td>
            <div v-show="isShowDeleteTeaching" @click="deleteTeaching(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
            <div @click="editTeaching(index)" class="icon-button"><i class="fas fa-edit"></i></div>
            <button @click="showDetail(index)" class="button is-small" type="button" name="button">查看详情</button>
            <button @click="addApplyFor(index)" class="button is-small" type="button" name="button">申请授课</button>
          </td>
          <td>
            <button @click="showUser(index)" class="button is-small" type="button" name="button">用户</button>
            <button @click="showPreview(index)" class="button is-small" type="button" name="button">预习</button>
            <button @click="showVideoInfo(index)" class="button is-small" type="button" name="button">视频</button>
            <button @click="showFileInfo(index)" class="button is-small" type="button" name="button">文件</button>
            <button @click="showDiscuss(index)" class="button is-small" type="button" name="button">讨论</button>
          </td>
        </tr>
      </tbody>
    </table>

    <add-teaching ref="addTeaching"
                  v-on:getTeaching="getTeaching"
    ></add-teaching>

    <edit-teaching ref="editTeaching"
                   v-on:getTeaching="getTeaching"
                   v-bind:edit-data="editData"
    ></edit-teaching>

    <user ref="user"
          v-bind:current-teaching-data="currentTeachingData"
    ></user>

    <detail ref="detail"
            v-bind:current-teaching-data="currentTeachingData"
    ></detail>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

    <video-info ref="videoInfo"
                v-bind:current-teaching-data="currentTeachingData"
                v-on:getTeaching="getTeaching"
    ></video-info>

    <file-info ref="fileInfo"
               v-bind:current-teaching-data="currentTeachingData"
               v-on:getTeaching="getTeaching"
    ></file-info>

    <preview ref="preview"
             v-bind:current-teaching-data="currentTeachingData"
             v-on:getTeaching="getTeaching"
    ></preview>

    <discuss ref="discuss"
             v-bind:current-teaching-data="currentTeachingData"
             v-on:getTeaching="getTeaching"
    ></discuss>


  </div>
</template>

<script>
import AddTeaching from './AddTeaching'
import EditTeaching from './EditTeaching'
import Pagination from './../Pagination'
import User from './User'
import Detail from './Detail'
import VideoInfo from '../VideoInfo/VideoInfo'
import FileInfo from '../FileInfo/FileInfo'
import Preview from '../Preview/Preview'
import Discuss from '../Discuss/Discuss'

export default {
  data() {
    return {
      isShowModal: false,
      teachingData: [],
      searchKey: null,
      editData: null,
      paginationData: null,
      data: null,
      currentTeachingData: null,
      // get all teaching
      currentTeaching: [],
      allTeaching: [],
      searchResult: [],
    }
  },
  components: {
    AddTeaching,
    EditTeaching,
    Pagination,
    User,
    Detail,
    VideoInfo,
    FileInfo,
    Preview,
    Discuss,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    getTeaching: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.teachingData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
        if (err.response.status === 401) {
          // alert('登录超时');
          // location.reload();
        }
      })
    },
    searchTeaching: function () {
      const that = this;
      if (!that.searchKey) {
        that.searchKey = '';
        that.getTeaching();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/lectures/${that.searchKey}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.teachingData = [];
        that.teachingData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    searchTeaching: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getTeaching();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allTeaching.length > 0) {
        let allData  = that.allTeaching;
        let len = that.allTeaching.length;
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
        that.teachingData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/lectures/`;
        that.getAllTeaching(url);
      }
    },
    getAllTeaching: function (url) {
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
            that.currentTeaching.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentTeaching.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllTeaching(that.url);
        }
        else {
          that.allTeaching = that.currentTeaching;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    deleteTeaching: function (index) {
      const that = this;
      let id = that.teachingData[index]['id'];
      let prompt = confirm("确认删除该授课？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/lectures/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          // that.teachingData = res.data.data;
          alert('删除成功')
          that.getTeaching()
        }).catch(err => {
          alert('删除失败')
          console.log(err)
        })
      }
    },
    editTeaching: function (index) {
      const that = this;
      that.editData = that.teachingData[index];
      that.$refs.editTeaching.switchModal();
    },
    addTeaching: function () {
      const that = this;
      that.$refs.addTeaching.switchModal();
    },
    showUser: function (index) {
      const that = this;
      that.currentTeachingData = that.teachingData[index];
      that.$refs.user.switchModal();
    },
    showVideoInfo: function (index) {
      const that = this;
      that.currentTeachingData = that.teachingData[index];
      that.$refs.videoInfo.switchModal();
    },
    showFileInfo: function (index) {
      const that = this;
      that.currentTeachingData = that.teachingData[index];
      that.$refs.fileInfo.switchModal();
    },
    showDetail: function (index) {
      const that = this;
      that.currentTeachingData = that.teachingData[index];
      that.$refs.detail.switchModal();
    },
    showPreview: function (index) {
      const that = this;
      that.currentTeachingData = that.teachingData[index];
      that.$refs.preview.switchModal();
    },
    showDiscuss: function (index) {
      const that = this;
      that.currentTeachingData = that.teachingData[index];
      that.$refs.discuss.switchModal();
    },
    addApplyFor: function (index) {
      const that = this;
      let userId = sessionStorage.getItem('userId');
      if (userId === that.teachingData[index].user_id) {
        alert ('不能给自己发送申请！');
        return;
      }

      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/applications`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          to: that.teachingData[index].user_id,
          action: 'create',
          resource_id: that.teachingData[index].id,
          resource_type: 'Lecture',
          data: '申请该授课',
        }
      }).then(res => {
        alert('发送申请成功');
        that.$emit('getApplyFor');   //第一个参数名为调用的方法名，第二个参数为需要传递的参
      }).catch(err => {
        alert('发送申请失败');
        console.log(err);
      })
    },
  },
  computed: {
    isShowCreateTeaching() {
      // return true;
      return sessionStorage.getItem('permissions').includes('lecture-store')
    },
    isShowSearchTeaching() {
      // return true;
      return sessionStorage.getItem('permissions').includes('lecture-show')
    },
    isShowDeleteTeaching() {
      // return true;
      return sessionStorage.getItem('permissions').includes('lecture-destroy')
    },
  },
  created() {
    this.getTeaching();
    // this.GLOBAL.searchRole(sessionStorage.getItem('userId'));
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.teachingData = value.data;
      that.paginationData = value.links;
    },
    allTeaching: function (value, oldValue) {
      const that = this;
      that.searchTeaching(that.searchKey);
    }
  }
}
</script>

<style lang="scss" scoped>
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
.add-teaching-button {
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
