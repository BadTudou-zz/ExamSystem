<!-- 查看用户 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入关键字">
        <!-- <button disabled @click="searchUser()" class="button" type="button" name="button">查找用户</button> -->
        <div @click="searchUser()" class="search-button"><i class="fas fa-search"></i></div>

      </div>
      <button disabled v-show="isShowUpdateUser" @click="updateUser()" class="button" type="button" name="button">同步用户</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>用户名</th>
          <th>别名</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th>操作</th>
          <!-- <th>查看</th> -->
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in userData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ toTime(item.created_at.date) }}</td>
          <td>{{ toTime(item.updated_at.date) }}</td>
          <td>
            <button v-show="isShowDeleteUser" @click="deleteUser(index)" class="delete" type="button">删除用户</button>
            <button @click="editUser(index)" class="button is-small" type="button">更改用户名</button>
            <button @click="changePassword(index)" class="button is-small" type="button">更改密码</button>
          </td>
          <!-- <td>
            <v-view></v-view>
          </td> -->
        </tr>
      </tbody>
    </table>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

    <edit-user ref="editUser"
               v-bind:edit-data="editData"
               v-on:getUser="getUser"
    ></edit-user>

    <change-password ref="changePassword"
                     v-bind:edit-data="editData"
                     v-on:getUser="getUser"
    ></change-password>
  </div>
</template>

<script>
import Pagination from './../Pagination.vue'
import moment from 'moment'
import editUser from './editUser'
import ChangePassword from './ChangePassword'
// import VView from './View'

export default {
  data() {
    return {
      userData: null,
      searchKey: null,
      isShowEditModal: false,
      currentUserData: null, // 当前选中的用户
      editData: null,
      // pagination
      paginationData: null,
      data: null,
      //
      // get all user
      currentUser: [],
      allUser: [],
      searchResult: [],
    }
  },
  components: {
    editUser,
    ChangePassword,
    // VView,
    Pagination,
  },
  methods: {
    toTime: function (time) {
      return moment(time).format('YYYY-MM-DD');
    },
    // 删除用户
    deleteUser: function (index) {
      const that = this;
      let id = that.userData[index]['id'];
      let prompt = confirm("确认删除该用户吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/users/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功！');
          that.getUser();
        }).catch(err => {
          alert('删除失败，请稍后再试')
          console.log(err)
        })
      }
    },
    // 全部用户
    getUser: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.userData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    // 查找用户
    // searchUser: function () {
    //   const that = this;
    //   if (!that.searchKey) {
    //     that.getUser();
    //     return;
    //   }
    //   axios({
    //     method: 'get',
    //     url: `${this.GLOBAL.localDomain}/api/v1/users/${that.searchKey}`,
    //     headers: {
    //       'Accept': 'application/json',
    //       'Authorization': sessionStorage.getItem('token'),
    //     }
    //   }).then(res => {
    //     that.userData = [];
    //     that.userData.push(res.data.data);
    //   }).catch(err => {
    //     console.log(err)
    //   })
    // },
    searchUser: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getUser();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allUser.length > 0) {
        let allData  = that.allUser;
        let len = that.allUser.length;
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
        that.userData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/users/`;
        that.getAllUser(url);
      }
    },
    getAllUser: function (url) {
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
            that.currentUser.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentUser.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllUser(that.url);
        }
        else {
          that.allUser = that.currentUser;
        }
      }).catch(err => {
        console.log(err);
      })
    },
    editUser: function (index) {
      const that = this;
      that.editData = that.userData[index];
      that.$refs.editUser.switchModal();
    },
    changePassword: function (index) {
      const that = this;
      that.editData = that.userData[index];
      that.$refs.changePassword.switchModal();
    },
    checkUsers: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/1/users/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        console.log(res)
      }).catch(err => {
        console.log(err)
      })
    },
    showEditModal: function (index) {
      const that = this;
      that.isShowEditModal = true;
      that.currentUserData = that.userData[index];
      //
    }
  },
  computed: {
    isShowUpdateUser() {
      // return true;
      return sessionStorage.getItem('permissions').includes('user-update')
    },
    isShowDeleteUser() {
      // return true;
      return sessionStorage.getItem('permissions').includes('user-destroy')
    },
  },
  created() {

    this.getUser();
    // this.checkUsers();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.userData = value.data;
      that.paginationData = value.links;
    },
    allUser: function (value, oldValue) {
      const that = this;
      that.searchUser(that.searchKey);
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
.add-user-button {
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
