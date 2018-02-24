<!-- 查看角色 -->
<template lang="html">
  <div class="box">
    <div>
      <div class="search-box">
        <input class="input search-input" type="text" placeholder="请输入你要查看的角色">
        <button class="button" type="button" name="button">查找角色</button>
      </div>
        <button @click="showModal()" class="button add-role-button" type="button" name="button">添加角色</button>
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
        <tr v-for="item in roleData">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.display_name }}</td>
          <td>{{ item.created_at }}</td>
          <td>{{ item.updated_at }}</td>
          <td><button @click="deleteRole()" class="button" type="button" name="button">删除角色</button></td>
        </tr>
      </tbody>
    </table>

    <div class="modal" :class="{'is-active' : isShowModal}">
      <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">添加角色</p>
          <button @click="showModal()" class="delete" aria-label="close"></button>
        </header>
        <section class="modal-card-body">
          <div class="box-item">
            <label>角色名称</label>
            <input class="input" type="text" placeholder="请输入英文角色名">
          </div>

          <div class="box-item">
            <label>显示的角色名称</label>
            <input class="input" type="text" placeholder="请输入中文角色名">
          </div>
          <div class="box-item">
            <label>角色描述</label>
            <input class="input" type="text">
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button is-success">确认</button>
          <button  @click="showModal()" class="button">取消</button>
        </footer>
      </div>
    </div>
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
        url: 'http://localhost:8000/api/v1/users/1/roles/',
        headers: {
          'Accept': 'application/json',
          'Authorization': that.token
        }
      }).then(res => {
        that.roleData = res.data.data;
        // debugger
      }).catch(err => {
        console.log(err)
      })
    },
    checkPermissions: function () {
      const that = this;
      axios({
        method: 'get',
        url: 'http://localhost:8000/api/v1/users/1/roles/',
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
