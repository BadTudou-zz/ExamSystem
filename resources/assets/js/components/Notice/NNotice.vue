<!-- 查看通知 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchNotification" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查看的通知">
        <button @click="searchNotice()" class="button" type="button" name="button">查找通知</button>
      </div>
        <button v-show="isShowCreateNotification" @click="addNotice()" class="button add-role-button" type="button" name="button">添加通知</button>
    </div>
    <div  v-for="(item,index) in noticeData" class="notice box">
      <div class="notification">
        <button v-show="isShowDeleteNotification" @click="deleteNotice(index)" class="delete"></button>
        {{ item.data}}
        <p>{{ GLOBAL.toTime(item.created_at) }}</p>
      </div>
    </div>

    <add-notice ref="addNotice"
                 v-on:getNotice="getNotice"
    ></add-notice>

    <pagination v-bind:pagination-data="paginationData"
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
        console.log(err)
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
    searchNotice: function () {
      const that = this;
      if (!that.searchKey) {
        that.searchKey = '';
        that.getNotice();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/organizations/${that.searchKey}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.noticeData = [];
        that.noticeData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    }
  },
  computed: {
    isShowCreateNotification() {
      return true;
      // return sessionStorage.getItem('permissions').includes(18)
    },
    isShowSearchNotification() {
      return true;
      // return sessionStorage.getItem('permissions').includes(19)
    },
    isShowUpdateNotification() {
      return true;
      // return sessionStorage.getItem('permissions').includes(20)
    },
    isShowDeleteNotification() {
      return true;
      // return sessionStorage.getItem('permissions').includes(21)
    },
  },
  created() {

    this.getNotice();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.permissionData = value.data;
      that.paginationData = value.links;
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
</style>
