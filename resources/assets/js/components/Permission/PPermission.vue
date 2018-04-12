<!-- 查看权限 -->
<template lang="html">
  <div class="box">
    <div>
      <div v-show="isShowSearchPermission" class="search-box">
        <input v-model="permissionId" class="input search-input" type="text" placeholder="请输入你要查看的权限">
        <button @click="searchPermission()" class="button" type="button" name="button">查找权限</button>
      </div>
        <button v-show="isShowCreatePermission" @click="addPermission()" class="button add-permission-button" type="button" name="button">添加权限</button>
        <button class="button add-permission-button" type="button" name="button">同步权限</button>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>权限名</th>
          <th>别名</th>
          <th>描述</th>
          <th>创建时间</th>
          <th>更新时间</th>
          <th v-show="isShowDeletePermission">操作</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in permissionData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.description }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td><button v-show="isShowDeletePermission" @click="deletePermission(index)" class="button" type="button" name="button">删除权限</button></td>
        </tr>
      </tbody>
    </table>

    <pagination v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>

    <add-permission ref="addPermission"
                    v-on:getPermission="getPermission"
    ></add-permission>

  </div>
</template>

<script>
import AddPermission from './AddPermission'
import Pagination from './../Pagination.vue'
export default {
  data() {
    return {
      permissionData: null,
      isShowModal: false,
      permissionId: null,
      paginationData: null,
      data: null,  // from Pagination.vue
    }
  },
  components: {
    AddPermission,
    Pagination,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    addPermission: function () {
      const that = this;
      that.$refs.addPermission.switchModal();
    },
    deletePermission: function (index) {
      const that = this;
      let id = that.roleData[index]['id'];
      let prompt = confirm("确认删除该权限吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/permissions/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': sessionStorage.getItem('token')
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
    getPermission: function (page = 1) {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/roles/1/permissions?page=${page}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token'),
        }
      }).then(res => {
        that.permissionData = res.data.data;
        that.paginationData = res.data.links;
      }).catch(err => {
        console.log(err)
      })
    },
    searchPermission: function () {
      const that = this;
      if (!that.permissionId) {
        that.getPermission();
      }

      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/permissions/${that.permissionId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': sessionStorage.getItem('token')
        }
      }).then(res => {
        that.permissionData = [];
        that.permissionData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
  },
  computed: {
    isShowCreatePermission() {
      return sessionStorage.getItem('permissions').includes(1);
    },
    isShowSearchPermission() {
      return sessionStorage.getItem('permissions').includes(2)
    },
    isShowDeletePermission() {
      return sessionStorage.getItem('permissions').includes(3)
    },
  },
  created() {
    this.getPermission();
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
.add-permission-button {
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
