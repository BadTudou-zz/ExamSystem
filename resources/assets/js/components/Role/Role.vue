<!-- 查看角色 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchRole" class="search-box">
        <input disabled v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查找的角色ID">
        <button disabled @click="searchRole()" class="button" type="button" name="button">查找角色</button>
      </div>
      <button v-show="isShowCreateRole" @click="addRole()" class="button add-role-button" type="button" name="button">添加角色</button>
      <button disabled v-show="isShowUpdateRole" @click="updateRole()" class="button add-role-button" type="button" name="button">同步角色</button>
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
          <th>权限</th>
          <th>用户</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in roleData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ GLOBAL.toTime(item.created_at) }}</td>
          <td>{{ GLOBAL.toTime(item.updated_at) }}</td>
          <td><button v-show="isShowDeleteRole" @click="deleteRole(index)" class="delete" type="button" name="button">删除角色</button></td>
          <td><button @click="showPermission(index)" class="button" type="button" name="button">查看权限</button></td>
          <td><button @click="showUser(index)" class="button" type="button" name="button">查看用户</button></td>
        </tr>
      </tbody>
    </table>

    <pagination v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

    <add-role ref="addRole"
              v-on:getRole="getRole"
    ></add-role>

    <permission ref="permission"
                v-bind:current-role-data="currentRoleData"
    ></permission>

    <user ref="user"
          v-bind:current-role-data="currentRoleData"
    ></user>

  </div>
</template>

<script>
import Pagination from './../Pagination.vue'
import AddRole from './AddRole'
import Permission from './Permission'
import User from './User'

export default {
  data() {
    return {
      roleData: null,
      isShowModal: false,
      searchKey: null,
      paginationData: null,
      data: null,
      currentRoleData: null,
    }
  },
  components: {
    AddRole,
    Pagination,
    Permission,
    User,
  },
  methods: {
    switchModal: function () {
      const that = this;
      that.$refs.addRole.switchModal();
    },
    // 删除用户
    deleteRole: function (index) {
      const that = this;
      let id = that.roleData[index]['id'];
      let prompt = confirm("确认删除该角色吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/roles/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token'),
          }
        }).then(res => {
          alert('删除成功！');
          that.getRole();
        }).catch(err => {
          alert('删除失败，请稍后再试')
          console.log(err)
        })
      }
    },
    getRole: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/roles/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.roleData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    addRole: function () {
      const that = this;
      that.$refs.addRole.switchModal();
    },
    // updateRole: function () {
    //   const that = this;
    //   that.$refs.updateRole.switchModal();
    // },
    // 查找用户
    searchRole: function () {
      const that = this;
      if (!that.searchKey) {
        that.getRole();
        return;
      }
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/roles/${that.searchKey}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.roleData = [];
        that.roleData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    showPermission: function (index) {
      const that = this;
      that.currentRoleData = that.roleData[index];
      that.$refs.permission.switchModal();
    },
    showUser: function (index) {
      const that = this;
      that.currentRoleData = that.roleData[index];
      that.$refs.user.switchModal();
    },
  },
  computed: {
    isShowCreateRole() {
      // return true;
      return sessionStorage.getItem('permissions').includes('role-store')
    },
    isShowSearchRole() {
      // return true;
      return sessionStorage.getItem('permissions').includes('role-show')
    },
    isShowUpdateRole() {
      // return true;
      return sessionStorage.getItem('permissions').includes('role-update')
    },
    isShowDeleteRole() {
      // return true;
      return sessionStorage.getItem('permissions').includes('role-destroy')
    },
  },
  created() {

    this.getRole();
  },
  watch: {
    data:function (value, oldValue) {
      const that = this;
      that.roleData = value.data;
      that.paginationData = value.links;
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
</style>
