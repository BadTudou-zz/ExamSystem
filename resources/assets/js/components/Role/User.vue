 <!-- 查看用户 -->
<template lang="html">
  <div class="modal" v-bind:class="{'is-active': isShowModal}">
    <div class="modal-background"></div>
    <div class="modal-content user-content">
      <div class="box user-box">
        <div>
          <button @click="addUser()" class="button add-user-button" type="button" name="button">添加用户</button>
          <button @click="synchronizeUser()" class="button add-user-button" type="button" name="button">同步用户</button>
          <button @click="deleteUser()" class="button" type="button" name="button">删除用户</button>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>是否选中</th>
              <th>ID</th>
              <th>用户名</th>
              <th>邮箱</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in userData">
              <td><input type="checkbox" v-bind:value="item.id" v-model="selectedUser" class="user-seleted"></td>
              <td>{{ item.id }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.email }}</td>
            </tr>
          </tbody>
        </table>

        <pagination v-bind:pagination-data="paginationData"
                    v-model="data"
        ></pagination>

      </div>
    </div>
    <button @click="switchModal()" class="modal-close is-large" aria-label="close"></button>

    <add-user ref="addUser"
              v-bind:role-id="roleId"
              v-on:getUser="getUser"
    ></add-user>

    <synchronize-user ref="synchronizeUser"
                      v-bind:role-id="roleId"
                      v-on:getUser="getUser"
    ></synchronize-user>

  </div>
</template>

<script>
import Pagination from './../Pagination'
import AddUser from './AddUser'
import SynchronizeUser from './SynchronizeUser'

export default {
  data() {
    return {
      isShowModal: false,
      userData: {
        id: '',
        name: '',
        email: '',
      },
      // 翻页
      paginationData: null,
      data: null,
      //
      roleId: null,
      selectedUser: [],

    }
  },
  components: {
    Pagination,
    AddUser,
    SynchronizeUser,
  },
  props: [
    'currentRoleData',
  ],
  methods: {
    switchModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    // 查看角色下的用户
    getUser: function () {
      const that = this;
      let id = that.roleId;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/roles/${id}/users`,
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
    deleteUser: function () {
      const that = this;
      let id = that.roleId;
      let params = that.GLOBAL.computedParams(that.selectedUser, 'users');
      let prompt = confirm("确认删除该用户吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/roles/${id}/users?${params}`,
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
    addUser: function () {
      const that = this;
      that.$refs.addUser.switchModal();
    },
    synchronizeUser: function () {
      const that = this;
      that.$refs.synchronizeUser.switchModal();
    },
  },
  created() {
    this.userData = [];
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.userData = value.data;
      that.paginationData = value.links;
    },
    currentRoleData: function (value, oldValue) {
      const that = this;
      that.roleId = value.id;
      that.getUser();
    }
  }
}
</script>

<style scoped>
table {
  margin: 35px auto 0 auto;
}
.user-box {
  width: 1300px;
}
.user-content {
  width: 1300px;
}
</style>
