<!-- 查看权限 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="permissionId" class="input search-input" type="text" placeholder="请输入你要查看的权限">
        <button @click="searchPermission()" class="button" type="button" name="button">查找权限</button>
      </div>
        <button @click="addPermission()" class="button add-role-button" type="button" name="button">添加权限</button>
        <button class="button add-role-button" type="button" name="button">同步权限</button>
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
        <tr v-for="item in permissionData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.description }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td><button v-show="isShowDeletePermission" @click="deletePermission()" class="button" type="button" name="button">删除权限</button></td>
        </tr>
      </tbody>
    </table>

    <pagination v-bind:pagination-data="paginationData"
                v-model="data"
    ></pagination>
    <add-permission ref="addPermission"></add-permission>

  </div>
</template>

<script>
import AddPermission from './AddPermission'
import Pagination from './../Pagination.vue'
export default {
  data() {
    return {
      token: null,
      permissionData: null,
      isShowModal: false,
      permissionId: null,
      paginationData: null,
      data: null,  // from Pagination.vue
      token: null,
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
    addPermission: function() {
      const that = this;
      that.$refs.addPermission.switchModal();
    },
    // 删除权限 ??参数
    deletePermission: function () {
      const that = this;
      let prompt = confirm("确认删除改权限吗？");
      if (prompt) {
        axios({
          method: 'delete',
          url: `${this.GLOBAL.localDomain}/api/v1/roles/1/permissions`,
          headers: {
            'Accept': 'application/json',
            'Authorization': that.token
          }
        }).then(res => {
          that.permissionData = res.data.data;
        }).catch(err => {
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
          // 'Authorization': this.$store.state.token,
          'Authorization': that.token,
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
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/permissions/${that.permissionId}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
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
      return this.$store.state.permissionIdList.includes(1)
    },
    isShowSearchPermission() {
      return this.$store.state.permissionIdList.includes(2)
    },
    isShowDeletePermission() {
      return this.$store.state.permissionIdList.includes(3)
    },
  },
  created() {
    this.token = sessionStorage.getItem('token');
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
