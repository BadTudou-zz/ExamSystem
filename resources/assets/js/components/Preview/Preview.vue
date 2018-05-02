<!-- 查看预习 -->
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

        <button @click="addPreview()" class="button add-preview-button" type="button" name="button">添加预习</button>

        <p v-if="!previewData" class="empty-message-prompt">暂无预习</p>
        <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
          <thead>
            <tr>
              <th>序号</th>
              <th>预习名称</th>
              <th>用户ID</th>
              <th>授课ID</th>
              <th>描述</th>
              <th>截止时间</th>
              <th>发布状态</th>
              <th>内容</th>
              <th>操作</th>
            </tr>
          </thead>
        <tbody>
            <tr v-for="(item,index) in previewData">
              <td>{{ item.id }}</td>
              <td>{{ item.preview_name }}</td>
              <td>{{ item.userid }}</td>
              <td>{{ item.cid }}</td>
              <td>{{ item.desc }}</td>
              <td>{{ GLOBAL.toTime(item.end_time) }}</td>
              <td>{{ computedPublishStatus(item.is_publish) }}</td>
              <td>{{ item.content }}</td>
              <td>
                <button @click="publishPreview(index)" class="button is-small" type="button" name="button">发布预习</button>
                <div @click="deletePreview(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
                <div @click="editPreview(index)" class="icon-button"><i class="fas fa-edit"></i></div>
              </td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>


    <add-preview ref="addPreview"
                 v-on:getPreview="getPreview"
                 v-bind:current-teaching-data="currentTeachingData"></add-preview>

    <edit-preview ref="editPreview"
                  v-on:getPreview="getPreview"
                  v-bind:edit-data="editData"
    ></edit-preview>

  </div>

</template>

<script>
import AddPreview from './AddPreview'
import EditPreview from './EditPreview'

export default {
  data() {
    return {
      isShowModal: false,
      previewData: null,
      searchKey: '',
      // get all preview
      currentPreview: [],
      allPreview: [],
      searchResult: [],
      editData: null,
      searchType: '',
    }
  },
  components: {
    AddPreview,
    EditPreview,
  },
  props: [
    'currentTeachingData'
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addPreview: function() {
      const that = this;
      that.$refs.addPreview.switchModal();
    },
    editPreview: function (index) {
      const that = this;
      that.editData = that.previewData[index];
      that.$refs.editPreview.switchModal();
    },
    deletePreview: function (index) {
      const that = this;
      let id = that.previewData[index]['id'];
      let prompt = confirm("确认删除该预习吗？");
      if (prompt) {
        axios({
          method: 'post',
          url: `${this.GLOBAL.localDomain}/api/v1/preview/delete`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          },
          params: {
            id: id,
          }
        }).then(res => {
          alert('删除成功');
          that.getPreview()
        }).catch(err => {
          alert('删除失败')
          console.log(err)
        })
      }
    },
    // 通过授课ID获取预习信息
    getPreviewForCid: function() {
      const that = this;
      let cid = that.currentTeachingData.id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/preview/selectForUserid`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          'cid': cid
        },
      }).then(res => {
        that.previewData = res.data;
      }).catch(err => {
        console.log(err);
      })
    },
    // 通过user获取预习信息
    getPreviewForUserId: function() {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/preview/selectForCid`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          userId: sessionStorage.getItem('userId')
        }
      }).then(res => {
        that.previewData = res.data.data;
        // that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
      })
    },
    getPreview: function() {
      const that = this;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/preview/selectAll`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.previewData = res.data;
      }).catch(err => {
        console.log(err);
      })
    },
    searchPreview: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getPreview();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allPreview.length > 0) {
        let allData  = that.allPreview;
        let len = that.allPreview.length;
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
        that.previewData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/previews/`;
        that.getAllPreview(url);
      }
    },
    getAllPreview: function (url) {
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

        let len = res.data.data.length ? res.data.data.length : that.getJsonLength(res.data.data);

        // data数据结构不一致 可能是数组/也可能是json
        if (res.data.data.length) {
          for (let i = 0; i < len; i++) {
            that.currentPreview.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentPreview.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllPreview(that.url);
        }
        else {
          that.allPreview = that.currentPreview;
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
          that.getPreview();
          break;
        case 'user-id-search':
          that.getPreviewForUserId();
          break;
        case 'lecture-id-search':
          that.getPreviewForCid();
          break;
      }
    },
    publishPreview: function (index) {
      const that = this;
      let previewId = that.previewData[index]['id']
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/preview/publish`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        },
        params: {
          id: previewId,
        }
      }).then(res => {
        that.getPreview();
        alert('发布成功');
      }).catch(err => {
        alert('发布失败');
        console.log(err);
      })
    },
    computedPublishStatus: function (value) {
      const that = this;
      let status = '';
      switch (value) {
        case 0:
          status = '未发布';
          break;
        case 1:
          status = '已发布';
          break;
      }
      return status;
    }
  },
  computed: {
    isShowCreatePreview() {
      // return true;
      return sessionStorage.getItem('permissions').includes('preview-store');
    },
    // isShowSearchPreview() {
    //   // return true;
    //   return sessionStorage.getItem('permissions').includes('question-show');
    // },
    isShowEditPreview() {
      // return true;
      return sessionStorage.getItem('permissions').includes('preview-update');
    },
    isShowDeletePreview() {
      // return true;
      return sessionStorage.getItem('permissions').includes('preview-destroy');
    }
  },
  created() {
  },
  watch: {
    isShowModal: function (value, oldValue) {
      const that = this;
      that.getPreview();
    },
    // currentTeachingData: function (value, oldValue) {
    //   const that = this;
    //   that.getPreview();
    // }
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
.add-preview-button {
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
