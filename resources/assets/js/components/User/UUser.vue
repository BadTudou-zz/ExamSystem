<!-- 查看用户 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input v-model="searchKey" class="input search-input" type="text" placeholder="请输入你要查看的用户的ID">
        <button @click="searchUser()" class="button" type="button" name="button">查找用户</button>
      </div>
        <button class="button add-user-button" type="button" name="button">添加用户</button>
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
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in userData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td>
            <button @click="deleteUser(index)" class="button" type="button" name="button">删除用户</button>
            <button @click="showEditModal(index)" class="button" type="button" name="button">编辑用户</button>
            <!-- <button @click="showEditModal(index)" class="button" type="button" name="button">更改密码</button> -->
          </td>
        </tr>
      </tbody>
    </table>

    <edit-user :is-show-edit-modal="isShowEditModal"
               :current-user-data="currentUserData">
    </edit-user>
  </div>
</template>

<script>
import editUser from './editUser.vue'

export default {
  data() {
    return {
      token: '',
      userData: null,
      isShowModal: false,
      searchKey: null,
      isShowEditModal: false,
      currentUserData: null, // 当前选中的用户
    }
  },
  components: {
    editUser,
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    // 删除用户
    deleteUser: function (index) {
      const that = this;
      let id = that.userData[index]['id'];
      let prompt = confirm("确认删除改用户吗？");
      if (prompt) {
        axios({
          method: 'put',
          url: `http://api/v1/users/${id}`,
          headers: {
            'Accept': 'application/json',
            'Authorization': that.token
          }
        }).then(res => {
          that.userData = res.data.data;
        }).catch(err => {
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
          'Authorization': that.token
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
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/${that.searchKey}`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.userData = [];
        that.userData.push(res.data.data);
      }).catch(err => {
        console.log(err)
      })
    },
    checkPermissions: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/1/users/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
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
  created() {
    this.token = sessionStorage.getItem('token');
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
