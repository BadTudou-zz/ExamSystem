<!-- 查看通知 -->
<template lang="html">
  <div>
    <div>
      <div v-show="isShowSearchNotification" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
        <!-- <button disabled @click="searchNotice()" class="button" type="button" name="button">查找通知</button> -->
        <div @click="searchNotice()" class="search-button"><i class="fas fa-search"></i></div>
      </div>
        <button v-show="isShowCreateNotification" @click="addNotice()" class="button add-role-button" type="button" name="button">添加通知</button>
    </div>

    <p v-if="!noticeData" class="empty-message-prompt">暂无通知</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <th>发送者</th>
          <th>接受者</th>
          <th>内容</th>
          <th>创建时间</th>
          <!-- <th>更新时间</th> -->
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <div v-if="!noticeData"></div>
        <tr v-else v-for="(item,index) in noticeData">
          <td>{{ item.from_name }}</td>
          <td>{{ item.to_name }}</td>
          <td><p class="limit-words">{{ item.data }}</p></td>
          <td>{{ GLOBAL.toTime(item.created_at.date) }}</td>
          <!-- <td>{{ GLOBAL.toTime(item.updated_at.date) }}</td> -->
          <td>
            <div v-show="isShowDeleteNotification" @click="deleteNotice(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>

            <!-- <button v-show="isShowDeleteNotification" @click="deleteNotice(index)" class="delete" type="button">删除消息</button> -->
          </td>
        </tr>
      </tbody>
    </table>


    <add-notice ref="addNotice"
                 v-on:getNotice="getNotice"
    ></add-notice>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>
  </div>
</template>

<script>
import AddNotice from './AddNotice'
import Pagination from './../Pagination.vue'
export default {
  data() {
    return {
      noticeData: null,
      isShowModal: false,
      paginationData: null,
      data: null,
      searchKey: null,
      // get all notice
      currentNotice: [],
      allNotice: [],
      searchResult: [],
    }
  },
  components: {
    AddNotice,
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addNotice: function () {
      const that = this;
      that.$refs.addNotice.switchModal();
    },
    getNotice: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/notifications/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.noticeData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err);
        if (err.response.status === 401) {
          // alert('登录超时');
          // location.reload();
        }
      })
    },
    deleteNotice: function (index) {
      const that = this;
      let id = that.noticeData[index]['id'];
      let prompt = confirm("确认删除该消息吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/notifications/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功');
          that.getNotice();
        }).catch(err => {
          alert('删除失败');
          console.log(err)
        })
      }
    },
    // searchNotice: function () {
    //   const that = this;
    //   that.noticeData = [];
    //   if (!that.searchKey) {
    //     that.searchKey = '';
    //     that.getNotice();
    //     return;
    //   }
    //   axios({
    //     method: 'get',
    //     url: `${this.GLOBAL.localDomain}/api/v1/notifications/${that.searchKey}`,
    //     headers: {
    //       'Accept': 'application/json',
    //       'Authorization': sessionStorage.getItem('token'),
    //     }
    //   }).then(res => {
    //     that.noticeData.push(res.data);
    //   }).catch(err => {
    //     console.log(err)
    //   })
    // },
    searchNotice: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getNotice();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allNotice.length > 0) {
        let allData  = that.allNotice;
        let len = that.allNotice.length;
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
        that.noticeData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/notices/`;
        that.getAllNotice(url);
      }
    },
    getAllNotice: function (url) {
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
            that.currentNotice.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentNotice.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllNotice(that.url);
        }
        else {
          that.allNotice = that.currentNotice;
        }
      }).catch(err => {
        console.log(err);
      })
    },
  },
  computed: {
    isShowCreateNotification() {
      // return true;
      return sessionStorage.getItem('permissions').includes('notification-store')
    },
    isShowSearchNotification() {
      // return true;
      return sessionStorage.getItem('permissions').includes('notification-show')
    },
    isShowEditNotification() {
      // return true;
      return sessionStorage.getItem('permissions').includes('notification-update')
    },
    isShowDeleteNotification() {
      // return true;
      return sessionStorage.getItem('permissions').includes('notification-destroy')
    },
  },
  created() {

    this.getNotice();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.noticeData = value.data;
      that.paginationData = value.links;
    },
    allNotice: function (value, oldValue) {
      const that = this;
      that.searchNotice(that.searchKey);
    }
  }
}
</script>

<style lang="scss">
.notice {
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
.add-role-button {
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
.notification p{
  margin-top: 25px;
  text-align: right;
}
.notification {
  background-color: #fff;
}
</style>
