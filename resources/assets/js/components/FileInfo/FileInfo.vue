<!-- 查看视频 -->
<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content">
      <div class="box">

        <div class="search-box">
          <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入视频">
          <div class="search-button"><i class="fas fa-search"></i></div>
        </div>
        <button @click="addFileInfo()" class="button add-file-button" type="button" name="button">添加视频</button>

        <p v-if="!fileData" class="empty-message-prompt">暂无视频</p>
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
            <tr v-for="(item,index) in fileData">
              <td>{{ item.id }}</td>
              <td>{{ item.fileName }}</td>
              <td>{{ item.filename }}</td>
              <td>{{ item.kp }}</td>
              <td>
                <div @click="deleteFile(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
                <div @click="editFileInfo(index)" class="icon-button"><i class="fas fa-edit"></i></div>
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


    <add-file-info ref="addFileInfo"
                    v-on:getFile="getFile"
                    v-bind:current-file-data="currentFileData"></add-file-info>

    <edit-file-info ref="editFileInfo"
                     v-on:getFile="getFile"
                     v-bind:edit-data="editData"
    ></edit-file-info>

  </div>

</template>

<script>
import AddFileInfo from './AddFileInfo'
import EditFileInfo from './EditFileInfo'
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      isShowModal: false,
      fileData: null,
      paginationData: null,
      data: null,
      searchKey: '',
      // get all file
      currentFile: [],
      allFile: [],
      searchResult: [],
      editData: null,
    }
  },
  components: {
    AddFileInfo,
    EditFileInfo,
    Pagination,
  },
  props: [
    'currentFileData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addFileInfo: function() {
      const that = this;
      that.$refs.addFileInfo.switchModal();
    },
    editFileInfo: function (index) {
      const that = this;
      that.editData = that.fileData[index];
      that.$refs.editFileInfo.switchModal();
    },
    deleteFile: function (index) {
      const that = this;
      let id = that.fileData[index]['id'];
      let prompt = confirm("确认删除该视频吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/delete/file`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          },
          params: {
            id: that.fileData[index]['id']
          }
        }).then(res => {
          alert('删除成功');
          that.getFile()
        }).catch(err => {
          alert('删除失败')
          console.log(err)
        })
      }
    },
    // 通过授课ID获取视频信息
    getFileForCid: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/selectForUserid/file`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          cid: that.cid,
        }
      }).then(res => {
        // that.fileData = res.data.data;
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
      })
    },
    // 通过user获取视频信息
    getFileForUserId: function() {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/selectForCid/file`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          userId: sessionStorage.getItem('userId')
        }
      }).then(res => {
        // that.fileData = res.data.data;
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
      })
    },
    getFile: function() {
      const that = this;
      // axios({
      //   method: 'get',
      //   url: `${this.GLOBAL.localDomain}/api/v1/files`,
      //   headers: {
      //     'Accept': 'application/json',
      //     'Authorization': sessionStorage.getItem('token'),
      //   }
      // }).then(res => {
      //   that.fileData = res.data.data;
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
    searchFile: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getFile();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allFile.length > 0) {
        let allData  = that.allFile;
        let len = that.allFile.length;
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
        that.fileData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/files/`;
        that.getAllFile(url);
      }
    },
    getAllFile: function (url) {
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
            that.currentFile.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentFile.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllFile(that.url);
        }
        else {
          that.allFile = that.currentFile;
        }
      }).catch(err => {
        console.log(err);
      })
    },

  },
  computed: {
    isShowCreateFile() {
      return true;
      // return sessionStorage.getItem('permissions').includes('file-store');
    },
    isShowSearchFile() {
      return true;
      // return sessionStorage.getItem('permissions').includes('file-show');
    },
    isShowEditFileInfo() {
      return true;
      // return sessionStorage.getItem('permissions').includes('file-update');
    },
    isShowDeleteFile() {
      return true;
      // return sessionStorage.getItem('permissions').includes('file-destroy');
    },
  },
  created() {
  },
  watch: {
    isShowModal: function () {
      const that = this;
      that.getFileForUserId();
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
  padding-right: 20px;
  display: inline-block;
  border-right: 1px solid #dedede;
}
.add-file-button {
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
