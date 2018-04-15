<!-- 查看用户 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入用户的ID">
        <button @click="searchUser()" class="button" type="button" name="button">查找用户</button>
      </div>
        <!-- <button class="button add-user-button" type="button" name="button">添加用户</button> -->
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
          <th>查看</th>
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
            <button v-show="isShowDeleteUser" @click="deleteUser(index)" class="button is-small" type="button">删除用户</button>
            <button @click="editUser(index)" class="button is-small" type="button">编辑用户</button>
            <button @click="changePassword(index)" class="button is-small" type="button">更改密码</button>
          </td>
          <td>
            <v-view></v-view>
          </td>
        </tr>
      </tbody>
    </table>


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
import moment from 'moment'
import editUser from './editUser'
import ChangePassword from './ChangePassword'
import VView from './View'

export default {
  data() {
    return {
      userData: null,
      searchKey: null,
      isShowEditModal: false,
      currentUserData: null, // 当前选中的用户
      editData: null,
    }
  },
  components: {
    editUser,
    ChangePassword,
    VView,
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

      }).catch(err => {
        console.log(err)
      })
    },
    // 查找用户
    searchUser: function () {
      const that = this;
      if (!that.searchKey) {
        that.getUser();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${that.searchKey}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.userData = [];
        that.userData.push(res.data.data);
      }).catch(err => {
        console.log(err)
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
    checkPermissions: function () {
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
    // this.checkPermissions();
  },
  watch: {
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
