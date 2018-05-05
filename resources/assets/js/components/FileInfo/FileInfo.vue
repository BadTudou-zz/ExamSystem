<!-- 查看文件 -->
<template lang="html">
  <div class="modal" :class="{'is-active' : isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content">
      <div class="box">

        <div class="search-box">
          <div class="field">
            <div class="control">
              <div class="select is-small">
                <select  v-model="searchType" @change="changeSeachType()">
                  <option value="">请选择查找类型</option>
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

        <button v-show="isShowCreateDocument" @click="addFileInfo()" class="button add-file-button" type="button" name="button">添加文件</button>

        <p v-if="!fileData" class="empty-message-prompt">暂无文件</p>
        <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
          <thead>
            <tr>
              <th>序号</th>
              <th>用户ID</th>
              <th>授课ID</th>
              <th>URL</th>
              <th>文件名</th>
              <th>知识点</th>
              <th>操作</th>
            </tr>
          </thead>
        <tbody>
            <tr v-for="(item,index) in fileData">
              <td>{{ item.id }}</td>
              <td>{{ item.userId }}</td>
              <td>{{ item.cid }}</td>
              <td>{{ GLOBAL.localDomain + item.url }}</td>
              <td>{{ item.doc_name }}</td>
              <td>{{ item.kp }}</td>
              <td>
                <div v-show="isShowDeleteDocument" @click="deleteFile(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
                <div v-show="isShowEditDocument" @click="editFileInfo(index)" class="icon-button"><i class="fas fa-edit"></i></div>
                <button class="button is-small" type="button" name="button"><a v-bind:href="item.url">下载文件</a></button>
              </td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>


    <add-file-info v-if="isShowCreateDocument"
                   ref="addFileInfo"
                   v-on:getFile="getFile"
                   v-bind:current-teaching-data="currentTeachingData"></add-file-info>

    <edit-file-info v-if="isShowEditDocument"
                    ref="editFileInfo"
                    v-on:getFileForCid="getFileForCid"
                    v-bind:edit-data="editData"
    ></edit-file-info>

  </div>

</template>

<script>
import AddFileInfo from './AddFileInfo'
import EditFileInfo from './EditFileInfo'

export default {
  data() {
    return {
      isShowModal: false,
      fileData: null,
      searchKey: '',
      // get all file
      currentFile: [],
      allFile: [],
      searchResult: [],
      editData: null,
      searchType: '',
      currentFileData: null,
    }
  },
  components: {
    AddFileInfo,
    EditFileInfo,
  },
  props: [
    'currentTeachingData'
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
      let prompt = confirm("确认删除该文件吗？");
      if (prompt) {
        axios({
          method: 'post',
          url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/delete/document`,
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
    // 通过授课ID获取文件信息
    getFileForCid: function() {
      const that = this;
      let cid = that.currentTeachingData.id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/selectForCid/document`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          'cid': cid
        },
      }).then(res => {
        that.fileData = res.data;
      }).catch(err => {
        console.log(err);
      })
    },
    // 通过user获取文件信息
    getFileForUserId: function() {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/selectForUserid/document`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          userId: sessionStorage.getItem('userId')
        }
      }).then(res => {
        that.fileData = res.data;
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
      })
    },
    getFile: function() {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/upload/lecture/selectAll/document`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.fileData = res.data;
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
      })
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
        method: 'post',
        url: urlPath,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.url = res.data.links.next;

        let len = res.data.length ? res.data.length : that.getJsonLength(res.data);

        // data数据结构不一致 可能是数组/也可能是json
        if (res.data.length) {
          for (let i = 0; i < len; i++) {
            that.currentFile.push(res.data[i]);
          }
        }
        else if (that.getJsonLength(res.data)) {
          for (let i in res.data) {
            that.currentFile.push(res.data[i]);
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
    changeSeachType: function () {
      const that = this;
      let searchType = that.searchType;
      switch (searchType) {
        case '':
          break;
        case 'fuzzy-search':
          that.getFile();
          break;
        case 'user-id-search':
          that.getFileForUserId();
          break;
        case 'lecture-id-search':
          that.getFileForCid();
          break;
      }
    }
  },
  computed: {
    isShowCreateDocument() {
      // return true;
      return sessionStorage.getItem('permissions').includes('document-store');
    },
    // isShowSearchDocument() {
    //   // return true;
    //   return sessionStorage.getItem('permissions').includes('question-show');
    // },
    isShowEditDocument() {
      // return true;
      return sessionStorage.getItem('permissions').includes('document-update');
    },
    isShowDeleteDocument() {
      // return true;
      return sessionStorage.getItem('permissions').includes('document-destroy');
    }
  },
  created() {
  },
  watch: {
    currentTeachingData: function (value, oldValue) {
      const that = this;
      that.getFile();
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
.field {
  display: inline-block;
}
</style>
