<!-- 查看申请 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchApplication" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
        <!-- <button disabled @click="searchApplyFor()" class="button is-small" type="button" name="button">查找申请</button> -->
        <div @click="searchApplyFor()" class="search-button"><i class="fas fa-search"></i></div>
      </div>
        <button v-show="isShowCreateApplication" @click="addApplyFor()" class="button add-applyFor-button is-small" type="button" name="button">添加申请</button>
    </div>
    <p v-if="!applyForData" class="empty-message-prompt">暂无申请</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <th>申请人</th>
          <th>批准人</th>
          <th>申请消息</th>
          <!-- <th>action</th> -->
          <!-- <th>resource_id</th> -->
          <th>resource_type</th>
          <th>创建时间</th>
          <th>操作</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="(item,index) in applyForData">
          <td>{{ item.from }}</td>
          <td>{{ item.to }}</td>
          <td>{{ item.data }}</td>
          <!-- <td>{{ item.action }}</td> -->
          <!-- <td>{{ item.resource_id }}</td> -->
          <td>{{ item.resource_type }}</td>
          <td>{{ GLOBAL.toTime(item.created_at.date) }}</td>
          <td>
            <!-- <button v-show="isShowDeleteApplication" @click="deleteApplyFor(index)" class="delete is-small" type="button" name="button">删除</button> -->
            <div v-show="isShowDeleteApplication" @click="deleteApplyFor(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
            <div @click="editApplyFor(index)" class="icon-button"><i class="fas fa-edit"></i></div>
            <button v-show="isShowAccpetApplication" @click="acceptApplyFor(index)" class="button is-small" type="button" name="button">接受</button>
            <button v-show="isShowRejectApplication" @click="rejectApplyFor(index)" class="button is-small" type="button" name="button">拒绝</button>
          </td>
        </tr>
      </tbody>
    </table>


    <add-apply-for ref="addApplyFor"
                   v-on:getApplyFor="getApplyFor"></add-apply-for>

    <edit-apply-for ref="editApplyFor"
                    v-on:getApplyFor="getApplyFor"
                    v-bind:edit-data="editData"></edit-apply-for>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>
  </div>
</template>

<script>
import AddApplyFor from './AddApplyFor'
import EditApplyFor from './EditApplyFor'
import Pagination from './../Pagination.vue'

export default {
  data() {
    return {
      isShowModal: false,
      searchKey: null,
      applyForData: null,
      editData: null,
      searchKey: null,
      paginationData: null,
      data: null,
      // get all applyFor
      currentApplyFor: [],
      allApplyFor: [],
      searchResult: [],
    }
  },
  components: {
    AddApplyFor,
    EditApplyFor,
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteApplyFor: function (index) {
      const that = this;
      let id = that.applyForData[index].id;
      let prompt = confirm("确认删除该申请吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功');
          that.getApplyFor();
        }).catch(err => {
          alert('删除失败');
          console.log(err);
        })
      }
    },
    searchApplyFor: function () {
      const that = this;
      let id = that.searchKey;
      if (!that.searchKey) {
        that.searchKey = '';
        that.getApplyFor();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.applyForData = [];
        that.applyForData.push(res.data.data);
        // that.applyForData = res.data.data;
      }).catch(err => {
        alert('没有找到从相关数据，已加载全部数据')
        console.log(err)
      })
    },
    searchApplyFor: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getApplyFor();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allApplyFor.length > 0) {
        let allData  = that.allApplyFor;
        let len = that.allApplyFor.length;
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
        that.applyForData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/applications/`;
        that.getAllApplyFor(url);
      }
    },
    getAllApplyFor: function (url) {
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
            that.currentApplyFor.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentApplyFor.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllApplyFor(that.url);
        }
        else {
          that.allApplyFor = that.currentApplyFor;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    getApplyFor: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        // that.applyForData = [];
        // that.applyForData.push(res.data.data);

        that.applyForData = res.data.data;

        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    addApplyFor: function () {
      const that = this;
      that.$refs.addApplyFor.switchModal();
    },
    editApplyFor: function (index) {
      const that = this;
      that.editData = that.applyForData[index];
      that.$refs.editApplyFor.switchModal();
    },
    acceptApplyFor: function (index) {
      const that = this;
      let id = that.applyForData[index].id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}/accept`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        // that.applyForData = [];
        // that.applyForData.push(res.data.data);
        alert('已接受')
      }).catch(err => {
        alert('接受失败，请稍后再试')
        console.log(err)
      })
    },
    rejectApplyFor: function (index) {
      const that = this;
      let id = that.applyForData[index].id;
      axios({
        method: 'post',
        url: `${this.GLOBAL.localDomain}/api/v1/applications/${id}/reject`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        alert('已拒绝')
        // that.applyForData = [];
        // that.applyForData.push(res.data.data);
      }).catch(err => {
        console.log(err)
        alert('拒绝失败，请稍后再试')
      })
    }
  },
  computed: {
    isShowCreateApplication() {
      // return true;
      return sessionStorage.getItem('permissions').includes('application-store');
    },
    isShowSearchApplication() {
      // return true;
      return sessionStorage.getItem('permissions').includes('application-show');
    },
    isShowAccpetApplication() {
      // return true;
      return sessionStorage.getItem('permissions').includes('application-accept');
    },
    isShowRejectApplication() {
      // return true;
      return sessionStorage.getItem('permissions').includes('application-reject');
    },
    isShowDeleteApplication() {
      // return true;
      return sessionStorage.getItem('permissions').includes('application-destroy');
    },
  },
  created() {
    this.getApplyFor();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.applyForData = value.data;
      that.paginationData = value.links;
    },
    allApplyFor: function (value, oldValue) {
      const that = this;
      that.searchApplyFor(that.searchKey);
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
.add-applyFor-button {
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
