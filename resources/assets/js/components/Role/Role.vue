<!-- 查看角色 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchRole" class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查找的角色ID">
        <div @click="searchRole()" class="search-button"><i class="fas fa-search"></i></div>
      </div>
      <button v-show="isShowCreateRole" @click="addRole()" class="button add-role-button" type="button" name="button">添加角色</button>
    </div>

    <p v-if="!roleData" class="empty-message-prompt">暂无角色</p>
    <table v-else class="table is-bordered is-striped is-hoverable is-fullwidths">
      <thead>
        <tr>
          <th>ID</th>
          <th>用户名</th>
          <th>别名</th>
          <th>创建时间</th>
          <!-- <th>更新时间</th> -->
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
          <!-- <td>{{ GLOBAL.toTime(item.updated_at) }}</td> -->
          <td>
            <!-- <button v-show="isShowDeleteRole" @click="deleteRole(index)" class="delete" type="button" name="button">删除角色</button> -->
            <div v-show="isShowDeleteRole" @click="deleteRole(index)" class="icon-button"><i class="far fa-trash-alt"></i></div>
            <div v-show="isShowEditRole" @click="editRole(index)" class="icon-button"><i class="fas fa-edit"></i></div>
          </td>
          <td><button @click="showPermission(index)" class="button" type="button" name="button">查看权限</button></td>
          <td><button @click="showUser(index)" class="button" type="button" name="button">查看用户</button></td>
        </tr>
      </tbody>
    </table>

    <pagination v-show="searchResult.length === 0"
                v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

    <add-role ref="addRole"
              v-on:getRole="getRole"
    ></add-role>

    <edit-role ref="editRole"
               v-on:getRole="getRole"
               v-bind:edit-data="editData"
    ></edit-role>

    <user ref="user"
          v-bind:current-role-data="currentRoleData"
    ></user>

    <permission  ref="permission"
                 v-bind:current-role-data="currentRoleData"
    ></permission>
  </div>
</template>

<script>
import Pagination from './../Pagination.vue'
import AddRole from './AddRole'
import User from './User'
import Permission from './Permission'
import EditRole from './EditRole'

export default {
  data() {
    return {
      roleData: null,
      isShowModal: false,
      searchKey: null,
      paginationData: null,
      data: null,
      currentRoleData: null,
      // get all role
      currentRole: [],
      allRole: [],
      searchResult: [],
      editData: null,
    }
  },
  components: {
    AddRole,
    Pagination,
    User,
    Permission,
    EditRole,
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
        if (err.response.status === 401) {
          // alert('登录超时');
          // location.reload();
        }
      })
    },
    addRole: function () {
      const that = this;
      that.$refs.addRole.switchModal();
    },
    editRole: function (index) {
      const that = this;
      that.editData = that.roleData[index];
      that.$refs.editRole.switchModal();
    },
    // 查找用户
    // searchRole: function () {
    //   const that = this;
    //   if (!that.searchKey) {
    //     that.getRole();
    //     return;
    //   }
    //   axios({
    //     method: 'get',
    //     url: `${this.GLOBAL.localDomain}/api/v1/roles/${that.searchKey}`,
    //     headers: {
    //       'Accept': 'application/json',
    //       'Authorization': sessionStorage.getItem('token'),
    //     }
    //   }).then(res => {
    //     that.roleData = [];
    //     that.roleData.push(res.data.data);
    //   }).catch(err => {
    //     console.log(err)
    //   })
    // },
    searchRole: function () {
      const that = this;
      // 如果没有搜索值
      if (!that.searchKey) {
        that.getRole();
        that.searchResult = [];
        return;
      }
      // 如果已经获取全部数据
      else if (that.allRole.length > 0) {
        let allData  = that.allRole;
        let len = that.allRole.length;
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
        that.roleData = res;
      }
      // 如果有搜索值并且还未获取全部数据
      else {
        let url = `${this.GLOBAL.localDomain}/api/v1/roles/`;
        that.getAllRole(url);
      }
    },
    getAllRole: function (url) {
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
            that.currentRole.push(res.data.data[i]);
          }
        }
        else if (that.getJsonLength(res.data.data)) {
          for (let i in res.data.data) {
            that.currentRole.push(res.data.data[i]);
          }
        }

        if (that.url) {
          that.getAllRole(that.url);
        }
        else {
          that.allRole = that.currentRole;
        }
      }).catch(err => {
        console.log(err);
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
    isShowEditRole() {
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
    },
    allRole: function (value, oldValue) {
      const that = this;
      that.searchRole(that.searchKey);
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
