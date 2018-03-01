<!-- 查看角色 -->
<template lang="html">
  <div class="box">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>用户名</th>
          <th>别名</th>
          <th>创建时间</th>
          <th>更新时间</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in roleData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
        </tr>
      </tbody>
    </table>

  </div>
</template>

<script>
export default {
  data() {
    return {
      token: '',
      roleData: null,

      isShowModal: false,
    }
  },
  components: {
  },
  methods: {
    showModal: function () {
      const that = this;
      that.isShowModal = !that.isShowModal;
    },
    deleteRole: function () {
      const that = this;
      let prompt = confirm("确认删除改角色吗？");
      if (prompt) {

      }
    },
    getRole: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/1/roles/`,
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.roleData = res.data.data;
        //
      }).catch(err => {
        console.log(err)
      })
    },
    checkPermissions: function () {
      const that = this;
      axios({
        method: 'get',
        url: `${this.GLOBAL.localDomain}/api/v1/users/1/roles/`,
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
  },
  created() {
    this.token = sessionStorage.getItem('token');
    this.getRole();
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
